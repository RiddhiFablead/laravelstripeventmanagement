@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-body text-center">
            
            <h2>Welcome Admin, {{ session('name') }}</h2>
            <p>Email: {{ session('email') }}</p>
            <a href="{{ url('/logout') }}" class="btn btn-danger">Logout</a>
        </div>
    </div>
</div>

{{-- <div class="container">
    <h2>Event Calendar</h2>
    <div id="calendar"></div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendar');

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: '/dashboard-events', // Laravel route
        eventClick: function(info) {
            alert(info.event.title + "\n" + info.event.start);
        }
    });

    calendar.render();
});
</script> --}}




@endsection