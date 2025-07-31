<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripePaymentController extends Controller
{
    //

    public function checkout(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'event_id' => 'required',
            'schedule_id' => 'required',
            'price' => 'required|numeric|min:1',
        ]);
        Session::put('name', $data['name']);
        Session::put('email', $data['email']);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $paymentIntent = PaymentIntent::create([
            'amount' => $data['price'] * 100,
            'currency' => 'inr',
            'description' => 'Booking for event ID:' . $data['event_id'],
            'receipt_email' => $data['email'],
            'metadata' => [
                'event_id' => $data['event_id'],
                'schedule_id' => $data['schedule_id'],
                'name' => $data['name'],
            ],
        ]);
        return view('stripe.checkout', [
            'clientSecret' => $paymentIntent->client_secret,
            'name' => $data['name'],
            'email' => $data['email'],
            'amount' => $data['price'],
        ]);
    }
    public function paymentSuccess()
    {
        return view('stripe.success'); 
    }
    public function paymentCancel()
    {
        return redirect()->back()->with('error', 'Payment cancelled.');
    }
}
    