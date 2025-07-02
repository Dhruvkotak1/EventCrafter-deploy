<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $total_bookings = Booking::where('user_id', $user->id)->count();
        $upcoming_events = Booking::where('user_id', $user->id)
            ->whereHas('event', function ($query) {
                $query->whereDate('date', '>=', now()->toDateString())
                    ->orWhere(function ($query) {
                        $query->whereDate('date', now()->toDateString())
                            ->whereTime('time', '>=', now()->toTimeString());
                    });
            })
            ->count();

        $events_attended =  Booking::where('user_id', $user->id)
            ->whereHas('event', function ($query) {
                $query->whereDate('date', '<', now()->toDateString())
                    ->orWhere(function ($query) {
                        $query->whereDate('date', now()->toDateString())
                            ->whereTime('time', '<', now()->toTimeString());
                    });
            })
            ->count();

        $feedbacks_given = Feedback::where('user_id', $user->id)->count();

        $stats = ['total_bookings' => $total_bookings, 'upcoming_events' => $upcoming_events, 'events_attended' => $events_attended, 'feedbacks_given' => $feedbacks_given];

        $upcomingBookings = Booking::where('user_id', $user->id)
            ->whereHas('event', function ($query) {
                $now = Carbon::now()->format('Y-m-d H:i:s');
                $query->whereRaw("STR_TO_DATE(CONCAT(date, ' ', time), '%Y-%m-%d %H:%i:%s') >= ?", [$now]);
            })
            ->with('event')
            ->get();


        return view('customer.dashboard', compact('stats', 'upcomingBookings'));
    }


    public function giveEventFeedback(Request $request)
    {
        $user = Auth::user();

        $attendedBookings = $user->bookings()
            ->with('event')
            ->get()
            ->filter(function ($booking) {
                if (!$booking->event) return false;

                $eventDateTime = Carbon::parse($booking->event->date . ' ' . $booking->event->time)->toDateTimeString();
                return now()->greaterThanOrEqualTo($eventDateTime);
            })
            ->unique(fn($booking) => $booking->event->id ?? null);

        $attendedEventsWithBooking = $attendedBookings
            ->map(function ($booking) use ($user) {
                $event = $booking->event;
                if (!$event) return null;

                $feedback = $event->feedbacks()->where('user_id', $user->id)->first();
                $event->user_feedback = $feedback;

                return (object)[
                    'event' => $event,
                    'booking_id' => $booking->id,
                    'seats' => $booking->seats,
                    'booking' => $booking,
                ];
            })
            ->filter(); // remove nulls

        return view('customer.giveEventFeedback', [
            'attendedEventsWithBooking' => $attendedEventsWithBooking
        ]);
    }


    public function cancelBookings(Request $request)
    {
        $user = $request->user();
        $bookings = $user->bookings()
            ->with('event')
            ->get()
            ->filter(function ($booking) {
                $event = $booking->event;
                $eventDateTime = Carbon::parse($event->date . ' ' . $event->time)->toDateTimeString();
                return now()->lt($eventDateTime) && now()->diffInHours($eventDateTime) >= 1; // show only future events
            });

        return view('customer.cancelBookings', compact('bookings'));
    }
}
