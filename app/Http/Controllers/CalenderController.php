<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class CalenderController extends Controller
{
    
    public function view()
    {
        return view ('calender');
    }
    public function getEvents()
    {
        $events=Event::with('schedules')->get();
        $calenderEvents=[];
        foreach ($events as $event){
            foreach($event->schedules as $schedule){
                $calenderEvents[]=[
                    'name'=>$event->name,
                    'date'=>$event->date,
                    'time'=>$event->time,
                ];
            }
        }
         return response()->json($calenderEvents);
    }
}
