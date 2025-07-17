@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">My Bookings</h3>

    @if($bookings->isEmpty())
        <div class="alert alert-info">You have no bookings yet.</div>
    @else
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Event Name</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                    <tr>
                        <td>{{ $booking->name }}</td>
                        <td>{{ $booking->email }}</td>
                        <td>{{ $booking->event_name }}</td>
                        <td>₹{{ number_format($booking->price, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->date)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->time)->format('h:i A') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
