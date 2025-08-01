<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function store(Request $request, Event $event)
    {

        $userId = session('id');
        if (!$userId) {

            return redirect()->back()->with('error', 'You must be logged to book');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'schedule_ids' => 'required',


        ]);
        // foreach($validated['schedule_ids']as $scheduleId){

        Booking::create([
            'user_id' => $userId,
            'event_id' => $request->eventid,
            'event_schedule_id' => $request->schedule_ids,
            'name' => $request->name,
            'email' => $request->email,

        ]);
        // }
        return back()->with('success', 'Booking successful!');
    }
    public function myBookings()
    {
        $userId = session('id');

        if (!$userId) {
            return redirect()->route('login')->with('error', 'please login to view bookings');
        }



        $bookings = Booking::select(
            'booking.id',
            'events.id as event_id',
            'events.name as events_name',
            'events.price',
            'events_schedules.date',
            'events_schedules.time',
            'booking.name as user_name'
        )
            ->join('events', 'booking.event_id', '=', 'events.id')
            ->join('events_schedules', 'booking.event_schedule_id', '=', 'events_schedules.id')
            ->where('booking.user_id', $userId)
            ->orderBy('events_schedules.date', 'desc')
            ->get();

        return view('event.customer.mybookings', compact('bookings'));
    }
}
