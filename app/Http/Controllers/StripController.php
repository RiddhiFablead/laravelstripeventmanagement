<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripController extends Controller
{
    //
    public function PaymentIntent(Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email',
            'event_id'=>'required|exists:events,id',
            'schedule_id'=>'required|exists:schedules',
            'price'=>'required|numeric',
        ]);
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $intent=PaymentIntent::create([
            'amount'=>$request->price,
            'currency'=>'inr',
            'description'=>'Event Booking',
            'metadata'=>[
                'name'=>$request->name,
                'email'=>$request->email,
                'event_id'=>$request->event_id,
                'schedule_id'=>$request->schedule_id
            ]
            ]);
            return response()->json([
                'clientSecret'=>$intent->client_secret,

            ]);
    }
    public function storeBooking(Request $request)
    {
        Booking::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'event_id'=>$request->event_id,
            'event_schedule_id'=>$request->schedule_id,
            'price'=>$request->price/100,
        ]);
        return response()->json(['success'=>true]);
    }
   
}
