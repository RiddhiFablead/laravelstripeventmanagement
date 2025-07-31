@extends('layouts.app')
@section('content')
<div class="container text-center py-5">
    <h2 class="text-success">Payment paymentSuccess</h2>
        <p>Thank you for your booking. You will receive a confirmation email shortly.</p>
           <a href="{{ route('customer.dashboard') }}" class="btn btn-primary mt-4">Back to Home</a>
</div>
@endsection