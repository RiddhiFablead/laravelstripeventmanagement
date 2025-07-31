@extends('layouts.app')

@section('content')
<div class="container text-center py-5">
    <h2 class="text-danger"> Payment Cancelled</h2>
    <p>Your payment was not completed. Please try again.</p>
    <a href="{{ route('home') }}" class="btn btn-warning mt-4">Return Home</a>
</div>
@endsection
