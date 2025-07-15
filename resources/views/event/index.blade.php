@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>All Events</h2>

    <a href="{{ route('events.create') }}" class="btn btn-success mb-3">+ Add New Event</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Location</th>
                <th>Image</th>
                <th>Schedules</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
                <tr>
                    <td>{{ $event->name }}</td>
                    <td>{{ $event->description }}</td>
                    <td>{{ $event->price }}</td>
                    <td>{{ $event->location }}</td>
                    <td>
                        @if($event->img)
                          
                            <img src="{{ asset('storage/' . $event->img) }}" width="80">

                        @else
                            No Image
                        @endif
                    </td>
                    <td>
                        @foreach($event->schedules as $schedule)
                            <div>{{ $schedule->date }} at {{ $schedule->time }}</div>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
