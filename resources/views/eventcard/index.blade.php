@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>All Events</h2>
    <div class="row">
        @foreach($events as $event)
            @foreach($event->schedules as $schedule)
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        <img src="{{ asset('storage/' . $event->img) }}" class="card-img-top" alt="{{ $event->name }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $event->name }}</h5>
                            <p class="card-text mb-1"><strong>Date:</strong> {{ \Carbon\Carbon::parse($schedule->date)->format('d M Y') }}</p>
                            <p class="card-text"><strong>Time:</strong> {{ \Carbon\Carbon::parse($schedule->time)->format('h:i A') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>
</div>
@endsection
