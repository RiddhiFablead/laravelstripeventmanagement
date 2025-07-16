@extends('layouts.app')

@section('content')



<div class="container mt-4">
    <div class="row">
        @forelse ($events as $event)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    @if ($event->img)
                        <img src="{{ asset('storage/' . $event->img) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="{{ asset('images/default-event.jpg') }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-center">{{ $event->name }}</h5>
                        <a href="{{ route('events.show', $event->id) }}" class="btn btn-primary mt-auto w-100">View</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">No events available.</p>
        @endforelse
    </div>
</div>


@endsection
