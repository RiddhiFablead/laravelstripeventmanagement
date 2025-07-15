@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        {{-- Event Image --}}
        <div class="col-md-6">
            @if ($event->img)
                <img src="{{ asset('storage/' . $event->img) }}" class="img-fluid rounded shadow">
            @else
                <img src="{{ asset('images/default-event.jpg') }}" class="img-fluid rounded shadow">
            @endif
        </div>

        {{-- Event Details --}}
        <div class="col-md-6">
            <h2>{{ $event->name }}</h2>
            <p><strong>Description:</strong> {{ $event->description }}</p>
            <p><strong>Price:</strong> ₹{{ $event->price }}</p>
            <p><strong>Location:</strong> {{ $event->location }}</p>

            <h5 class="mt-4">Available Schedules:</h5>
            <ul>
                @foreach ($event->schedules as $schedule)
                    <li>{{ \Carbon\Carbon::parse($schedule->date)->format('d M Y') }} at {{ \Carbon\Carbon::parse($schedule->time)->format('h:i A') }}</li>
                @endforeach
            </ul>

            <button type="button" class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#bookingModal">Book Now</button>


        </div>
    </div>
</div>


<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('book.event', $event->id) }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Book Event</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        
        <div class="modal-body">
        
          <div class="mb-3">
              <label>Your Name</label>
             <input type="text" name="name" class="form-control" value="{{ session('name') }}" required>
          </div>

      
          <div class="mb-3">
              <label>Your Email</label>
             <input type="text" name="name" class="form-control" value="{{ session('email') }}" required>
          </div>

          <!-- Multiple Schedules -->
          <div class="mb-3">
              <label>Select Date & Time</label>
              <select name="schedule_ids[]" class="form-control" multiple required>
                  @foreach ($event->schedules as $schedule)
                      <option value="{{ $schedule->id }}">
                          {{ \Carbon\Carbon::parse($schedule->date)->format('d M Y') }}
                          at {{ \Carbon\Carbon::parse($schedule->time)->format('h:i A') }}
                      </option>
                  @endforeach
              </select>
             
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Book</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
