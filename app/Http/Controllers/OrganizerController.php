<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Feedback;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class OrganizerController extends Controller
{
    public function dashboard()
    {
        $total_events = Event::where("user_id", Auth::user()->id)->count();
        $upcoming_events = Event::where('user_id', Auth::user()->id)
            ->where('date', '>=', Carbon::today())
            ->count();
        $total_bookings = Booking::whereIn('event_id', Event::where("user_id", Auth::user()->id)->pluck('id'))->sum('number_of_tickets');
        $average_rating = Feedback::whereIn('event_id', Event::where("user_id", Auth::user()->id)->pluck('id'))->average('rating');
        $stats = [
            'total_events' => $total_events,
            'upcoming_events' => $upcoming_events,
            'total_bookings' => $total_bookings,
            'average_rating' => round($average_rating,2)
        ];

        $upcomingEvents = Event::where('user_id', Auth::user()->id)
        ->where('date', '>=', Carbon::today())->get();

        return view('organizer.dashboard', compact('stats','upcomingEvents'));
    }

    public function createEvent()
    {
        return view('organizer.createEvent');
    }

    public function manageEvent()
    {
        $events = (new EventController)->index();
        return view('organizer.manageEvent', compact('events'));
    }

    public function viewFeedback()
    {
        $events = Event::where("user_id", Auth::user()->id)->pluck('id');
        $feedbacks = Feedback::whereIn('event_id', $events)->get();
        return view('organizer.viewFeedback', compact('feedbacks'));
    }
}
