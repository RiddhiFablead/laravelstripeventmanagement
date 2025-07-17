@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-body text-center">
                <h2>Welcome Admin, {{ session('name') }}</h2>
                <p>Email: {{ session('email') }}</p>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <h2>🎀 Event Calendar</h2>
        <div id="calendar"></div>
    </div>

        

    <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title">Event Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-2">
                            <label>Name</label>
                            <input type="text" id="eventName" class="form-control" readonly>
                        </div>
                        <div class="mb-2">
                            <label>Description</label>
                            <textarea id="eventDescription" class="form-control" readonly></textarea>
                        </div>
                        <div class="mb-2">
                            <label>Location</label>
                            <input type="text" id="eventLocation" class="form-control" readonly>
                        </div>
                        <div class="mb-2">
                            <label>Price</label>
                            <input type="text" id="eventPrice" class="form-control" readonly>
                        </div>
                        <div class="mb-2">
                            <label>Date</label>
                            <input type="text" id="eventDate" class="form-control" readonly>
                        </div>
                        <div class="mb-2">
                            <label>Time</label>
                            <input type="text" id="eventTime" class="form-control" readonly>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById("calendar");
            const modal = new bootstrap.Modal(document.getElementById("eventModal"));

            // Load calendar events
            $.getJSON('{{ route("events.data") }}', function (events) {
                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    events: events,
                    dateClick: function (info) {
                        $.post('{{ route("events.byDate") }}', {
                            date: info.dateStr,
                            _token: '{{ csrf_token() }}'
                        }, function (res) {
                            if (res && res.name) {
                                $("#eventName").val(res.name);
                                $("#eventDescription").val(res.description);
                                $("#eventLocation").val(res.location);
                                $("#eventPrice").val(res.price);
                                $("#eventDate").val(res.date);
                                $("#eventTime").val(res.time);
                                modal.show();
                            } else {
                                alert("No event on this date.");
                            }
                        }, 'json');
                    }
                });

                calendar.render();
            });

           
            $.ajax({
                url: '{{ route("events.cards") }}',
                type: 'GET',
                dataType: 'json',
                success: function (events) {
                    let html = '';
                    events.forEach(event => {
                        html += `
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="/storage/${event.img ?? 'default.jpg'}" class="card-img-top" alt="${event.name}">
                                <div class="card-body">
                                    <h5 class="card-title">${event.name}</h5>
                                    <p class="card-text"><strong>Date:</strong> ${event.date}</p>
                                    <p class="card-text"><strong>Time:</strong> ${event.time ?? ''}</p>
                                </div>
                            </div>
                        </div>`;
                    });
                    $('#eventCards').html(html);
                },
               
            });
        });
    </script>
@endpush
