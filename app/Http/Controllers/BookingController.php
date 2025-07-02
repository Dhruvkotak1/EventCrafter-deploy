<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\SendBookingCancelledEmail;
use App\Jobs\SendBookingConfirmedEmail;
use App\Models\Booking;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::whereIn('event_id', Event::where("user_id", Auth::user()->id)->pluck('id'))->count('event_id');
        return $bookings;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'event_id' => 'required'
        ]);

        $event = Event::where('id', $request->event_id)->first();
        $tickets_left = $event->total_tickets - $event->tickets_booked;
        if ($request->quantity <= $tickets_left) {
            $booking = new Booking();
            $booking->user_id = $request->user()->id;
            $booking->event_id = $event->id;
            $booking->booking_date = Carbon::now()->format('Y/m/d');
            $booking->number_of_tickets = $request->quantity;
            $booking->amount_paid = $event->price * $request->quantity;
            if ($booking->save()) {
                $event->tickets_booked = $event->tickets_booked + $request->quantity;
                if ($event->save()) {
                    dispatch(new SendBookingConfirmedEmail($request->user()->email, $request->user(), $event, $booking));
                    return redirect()->back()->with('success', "Booking Successfull");
                }
            }
            return redirect()->back()->with('error', 'Booking Failes');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user();
        $booking = Booking::where('id',$id)->first();
        $event = Event::where('id',$booking->event_id)->first();

        return view('pdfs.invoice',compact('user','booking','event'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $booking = Booking::where('id',$id)->first();
        $event = Event::where('id',$booking->event_id)->first();
        $event->tickets_booked = $event->tickets_booked-$booking->number_of_tickets;
        $bookingData=  $booking->toArray();
        if($event->save()){
            dispatch(new SendBookingCancelledEmail(Auth::user(), $event, $bookingData, Auth::user()->email));
            $booking->delete();
            return redirect()->back()->with('success',"Booking Cancelled");
            
        }
        return redirect()->back()->with('error','Booking not cancelled');
    }

    public function download(string $id){
        $user = Auth::user();
        $booking = Booking::where('id',$id)->first();
        $event = Event::where('id',$booking->event_id)->first();

        $pdf = Pdf::loadView('pdfs.invoice',compact('user','booking','event'));
        return $pdf->download('EC_ticket_'.$booking->id.".pdf");
    }


    
}
