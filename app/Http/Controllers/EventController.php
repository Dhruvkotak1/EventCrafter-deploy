<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\SendBookingConfirmedEmail;
use App\Mail\BookingConfirmed;
use App\Models\Booking;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::where('user_id', Auth::user()->id)->get();
        return $events;
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|max:50',
            'description' => 'required|min:10|max:600',
            'image' => 'required|url',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'venue' => 'required',
            'price' => 'required|integer',
            'total_tickets' => 'required|integer|max:1000',
        ]);

        $event = new Event();
        $event->user_id = Auth::user()->id;
        $event->title = $request->title;
        $event->description = $request->description;
        $event->image = $request->image;
        $event->date = $request->date;
        $event->time = $request->time;
        $event->venue = $request->venue;
        $event->price = $request->price;
        $event->total_tickets = $request->total_tickets;

        if ($event->save()) {
            return redirect(route('organizers.createEvent'))->with("success", "Event Created successfully");
        }
        return redirect(route('organizers.createEvent'))->back()->with("error", "Event Not created");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::where('id', $id)->first();
        return view('bookTickets', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $event = Event::where('user_id', Auth::user()->id)->where('id', $id)->first();
        if ($event) {
            $request->validate([
                'title' => 'required|min:3|max:50',
                'description' => 'required|min:10|max:600',
                'image' => 'required|url',
                'date' => 'required|date|after_or_equal:today',
                'time' => 'required',
                'venue' => 'required',
                'price' => 'required|integer',
            ]);
            $event->user_id = Auth::user()->id;
            $event->title = $request->title;
            $event->description = $request->description;
            $event->image = $request->image;
            $event->date = $request->date;
            $event->time = $request->time;
            $event->venue = $request->venue;
            $event->price = $request->price;

            if ($event->save()) {
                return redirect(route('organizers.manageEvent'))->with("success", "Event Updated Successfully");
            }
            return redirect(route('organizers.manageEvent'))->back()->with("error", "Event Not Updated");
        } else {
            return redirect(route('organizers.manageEvent'))->back()->with("error", "Event Not Found");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {   
        $eventBookings = Booking::where('event_id',$id)->exists();
        if($eventBookings){
            return redirect(route("organizers.manageEvent"))->with('error','Event is booked, you cannot delete it.');
        }
        $deleteEvent = Event::where("id", $id)->delete();

        if ($deleteEvent) {
            return redirect(route('organizers.manageEvent'))->with('success', 'Event delete successfully');
        }
        return redirect(route('organizers.manageEvent'))->with('error', "Failed to delete this event");
    }

    public function browse(Request $request)
    {

        $query = Event::query();

        if ($request->filled('venue')) {
            $query->where('venue', 'like', '%' . $request->venue . '%');
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('date')) {
            $query->whereDate('date', '=', $request->date);
        } else {
            $query->whereDate('date', '>=', now());
        }

        $events = $query->orderBy('date')->get();

        return view('browseEvents', compact('events'));
    }

}
