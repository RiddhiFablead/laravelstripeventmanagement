<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session as FacadesSession;

class CustomerController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('customerdashboard', compact('events'));
    }
    public function show($id)
    {
        $event = Event::with('schedules')->findOrFail($id);

       
      

        return view('event_detail', compact('event'));
    }
   public function book(Request $request,Event $event)
   {
    $validated=$request->validate([
        'name'=>'required|string|max:255',
        'email'=>'required|email',
          'schedule_ids' => 'required|array',
        'schedule_ids.*' => 'exists:event_schedules,id',
    ]);
    foreach ($validated['schedule_ids']as $scheduleId){
        Booking::create([
            'event_id'=>$event->id,
            'event_schedule_id'=>$scheduleId,
            'name'=>$validated['name'],
            'email'=>$validated['email'],

        ]);
    }
     return back()->with('success', 'Booking successful!');
   }
 
      
}
