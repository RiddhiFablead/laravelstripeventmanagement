@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>All Events</h2>

    <a href="{{ route('events.create') }}" class="btn btn-success mb-3">+ Add New Event</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table id="eventsTable" class="table table-bordered table-striped">
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
                        <td>₹{{ $event->price }}</td>
                        <td>{{ $event->location }}</td>
                        <td>
                            @if($event->img)
                                <img src="{{ asset('storage/' . $event->img) }}" width="80" class="img-thumbnail">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>
                            @foreach($event->schedules as $schedule)
                                <div>{{ \Carbon\Carbon::parse($schedule->date)->format('d M Y') }} at {{ \Carbon\Carbon::parse($schedule->time)->format('h:i A') }}</div>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Initialization -->
    <script>
        $(document).ready(function () {
            $('#eventsTable').DataTable({
                responsive: true,
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                lengthChange: true
            });
        });
    </script>
@endpush

