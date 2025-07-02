<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Feedback;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function adminLogin()
    {
        return view('admin.adminLogin');
    }
    public function adminLoginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admin,email',
            'password' => 'required',
            'secret_code' => 'required'
        ]);
        $credentials = $request->only('email', 'password', 'secret_code');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect(route('admin.dashboard'))->with('success', 'Logged in successfully');
        }
        return redirect(route('admin.login'))->with('error', 'Credentials not matched');
    }

    public function dashboard(Request $request)
    {
        $totalEvents = Event::all()->count();
        $upcomingEvents = Event::where('date', '>', now()->toDateString())->count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalOrganizers = User::where('role', 'organizer')->count();
        $totalBookings = Booking::all()->count();
        $totalSeatsBooked = Event::all('tickets_booked')->sum('tickets_booked');
        $totalSeatsAvailable = Event::all('total_tickets')->sum('total_tickets');
        $totalBookingAmount = Booking::all()->sum('amount_paid');
        $averageRating = Feedback::all()->average('rating');
        $totalReviews = Feedback::all()->count();

        $dates = [];
        $bookingsData = [];
        $revenueData = [];

        for ($i=6; $i>=0 ; $i--) { 
            $date = Carbon::today()->subDays($i);
            $formattedDate = $date->format('Y-m-d');
            $displayDate = $date->format('D');

            $dailyBookings = Booking::where('booking_date',$formattedDate)->sum('number_of_tickets');
            $dailyRevenue = Booking::where('booking_date',$formattedDate)->sum('amount_paid') * 0.3;

            $dates[] = $displayDate;
            $bookingsData[] = $dailyBookings; 
            $revenueData[] = round($dailyRevenue,2);
        }

        return view('admin.dashboard', [
            'totalEvents' => $totalEvents,
            'upcomingEvents' => $upcomingEvents,
            'totalUsers' => $totalCustomers + $totalOrganizers,
            'totalCustomers' => $totalCustomers,
            'totalOrganizers' => $totalOrganizers,
            'totalBookings' => $totalBookings,
            'totalRevenue' => $totalBookingAmount,
            'platformRevenue' => $totalBookingAmount * 0.3,
            'averageRating' => $averageRating,
            'totalReviews' => $totalReviews,
            'totalSeatsBooked' => $totalSeatsBooked,
            'totalSeatsAvailable' => $totalSeatsAvailable,
            'chartLabels' => $dates,
            'chartBookings' => $bookingsData,
            'chartRevenue' => $revenueData,
        ]);
    }

    public function manageUpcomingEvents(Request $request)
    {
        $query = Event::with('organizer')
            ->whereDate('date', '>=', now()->toDateString())
            ->orderBy('date');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('venue', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->date) {
            $query->whereDate('date', $request->date);
        }

        if ($request->organizer) {
            $query->where('user_id', $request->organizer);
        }

        $events = $query->get();
        $organizers = User::where('role', 'organizer')->get();
        return view('admin.manageUpcomingEvents', compact('events', 'organizers'));
    }

    public function update(Request $request, string $id)
    {
        $event = Event::where('id', $id)->first();
        if ($event) {
            $request->validate([
                'title' => 'required|min:3|max:50',
                'date' => 'required|date|after_or_equal:today',
                'time' => 'required',
                'venue' => 'required',

            ]);
            $event->title = $request->title;
            $event->date = $request->date;
            $event->time = $request->time;
            $event->venue = $request->venue;

            if ($event->save()) {
                return redirect(route('admin.events.upcoming'))->with("success", "Event Updated Successfully");
            }
            return redirect(route('admin.events.upcoming'))->back()->with("error", "Event Not Updated");
        } else {
            return redirect(route('admin.events.upcoming'))->back()->with("error", "Event Not Found");
        }
    }

    public function destroy(string $id)
    {
        $eventBookings = Booking::where('event_id', $id)->exists();
        if ($eventBookings) {
            return redirect(route("admin.events.upcoming"))->with('error', 'Event is booked, you cannot delete it.');
        }
        $deleteEvent = Event::where("id", $id)->delete();

        if ($deleteEvent) {
            return redirect(route('admin.events.upcoming'))->with('success', 'Event delete successfully');
        }
        return redirect(route('admin.events.upcoming'))->with('error', "Failed to delete this event");
    }

    public function pastEvents(Request $request)
    {
        $query = Event::with(['organizer', 'bookings'])
            ->whereDate('date', '<', Carbon::today());

        // Apply filters
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('venue', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->from) {
            $query->whereDate('date', '>=', $request->from);
        }

        if ($request->to) {
            $query->whereDate('date', '<=', $request->to);
        }

        if ($request->organizer) {
            $query->where('user_id', $request->organizer);
        }

        $events = $query->orderByDesc('date')->get();
        $organizers = User::where('role', 'organizer')->get();
        return view('admin.pastEvents', compact('events', 'organizers'));
    }

    public function manageUsers(Request $request)
    {
        $blockedCustomersCount = User::where('role', 'customer')->where('status', 'blocked')->count();
        $blockedOrganizersCount = User::where('role', 'organizer')->where('status', 'blocked')->count();

        $sortField = $request->get('sort', 'id');
        $allowedSorts = ['id', 'name'];
        $sortField = in_array($sortField, $allowedSorts) ? $sortField : 'id';

        $customers = User::where('role', 'customer')
            ->when($request->customer_search, fn($q) =>
            $q->where('name', 'like', "%{$request->customer_search}%")
                ->orWhere('id', $request->customer_search))
            ->orderBy($sortField)
            ->get();

        $organizers = User::where('role', 'organizer')
            ->when($request->organizer_search, fn($q) =>
            $q->where('name', 'like', "%{$request->organizer_search}%")
                ->orWhere('id', $request->organizer_search))
            ->orderBy($sortField)
            ->get();
        return view('admin.manageUsers', compact('blockedCustomersCount', 'blockedOrganizersCount', 'customers', 'organizers'));
    }

    public function toggleUsers(string $id)
    {
        $user = User::where('id', $id)->first();
        if ($user->status == 'blocked') {
            $user->status = 'unblocked';
            $user->save();
            return redirect()->back()->with("success", "User Unblocked");
        }
        if ($user->status == 'unblocked') {
            $user->status = 'blocked';
            $user->save();
            return redirect()->back()->with('error', "User Blocked");
        }
        return redirect()->back()->with('info', 'user not found');
    }

    public function viewBookings()
    {
        $upcomingChartData = Event::whereDate('date', '>=', now())->get()->map(function ($event) {
            $booked = $event->tickets_booked;
            $total = $event->total_tickets;
            $percent = $total > 0 ? round(($booked / $total) * 100, 1) : 0;
            return [
                'event' => $event->title,
                'date' => $event->date,
                'booked' => $booked,
                'total' => $total,
                'not_booked' => max($total - $booked, 0),
                'percent' => $percent,
            ];
        })->sortByDesc('percent')->values();
        
        $pastChartData = Event::whereDate('date', '<', now())->get()->map(function ($event) {
            $booked = $event->tickets_booked;
            $total = $event->total_tickets;
            $percent = $total > 0 ? round(($booked / $total) * 100, 1) : 0;
            return [
                'event' => $event->title,
                'date' => $event->date,
                'booked' => $booked,
                'total' => $total,
                'not_booked' => max($total - $booked, 0),
                'percent' => $percent,
            ];
        })->sortByDesc('percent')->values();

        return view('admin.viewBookings', compact('upcomingChartData','pastChartData'));
    }

    public function feedbackReports(){
        $events = Event::with('feedbacks')->where('date','<',now())->get();
        $events->map(function ($event) {
            $event->avgRating = round($event->feedbacks->avg('rating'), 1);
            return $event;
        });
        
        return view('admin.feedbackReports',compact('events'));
    }
}
