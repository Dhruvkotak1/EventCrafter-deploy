<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class FeedBackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'event_id' => 'required|exists:events,id',
            'booking_id' => 'required|exists:bookings,id',
            'rating' => 'required|min:1|max:5',
            'feedback' => 'required|string|max:1000'
        ]);
        

        $feedback = new FeedBack();
        $feedback->user_id = $request->user()->id;
        $feedback->booking_id = $request->booking_id;
        $feedback->event_id = $request->event_id;
        $feedback->rating = $request->rating;
        $feedback->feedback = $request->feedback;

        if($feedback->save()){
            return redirect()->back()->with("success","Feedback submmitted successfully");
        }
        return redirect()->back()->with("error","Feedback not submitted");
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $request->validate([
            'feedback' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Feedback::where('id',$id)->update([
            'feedback' => $request->feedback,
            'rating' => $request->rating
        ]);

        return back()->with('success', 'Feedback updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
