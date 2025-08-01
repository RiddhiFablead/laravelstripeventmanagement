<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
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
             'phone' => 'required|string|min:10|max:15',
            'event_id' => 'required',
            'schedule_id' => 'required',
            'price' => 'required|numeric|min:1',
        ]);
        Session::put('name', $data['name']);
        Session::put('email', $data['email']);
          Session::put('phone', $data['phone']);

        Stripe::setApiKey(config('services.stripe.secret'));
        //    dd(config('services.stripe.secret'));
       


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
            'phone'=>$data['phone'],
        ]);
    }
  public function paymentSuccess()
    {
        $name = Session::get('name');
        $email = Session::get('email');
        $phone = Session::get('phone');

        try {
            $twilioSid = env('TWILIO_SID');
            $twilioToken = env('TWILIO_TOKEN');
            $twilioFrom = env('TWILIO_FROM');

            $twilio = new Client($twilioSid, $twilioToken);

            $twilio->messages->create(
                $phone,
                [
                    'from' => $twilioFrom,
                    'body' => "Hi $name, your booking was successful. Thank you for using our service!"
                ]
            );
        } catch (\Exception $e) {
            \Log::error("Twilio SMS failed: " . $e->getMessage());
        }

        return view('stripe.success');
    }

    public function paymentCancel()
    {
        return redirect()->back()->with('error', 'Payment cancelled.');
    }
}
    