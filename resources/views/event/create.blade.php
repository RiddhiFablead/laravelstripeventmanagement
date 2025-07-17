@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="card p-4">
    <h4>Add New Event</h4>
    <form method="POST" enctype="multipart/form-data" id="addEventForm" action="{{ route('events.store') }}">

      @csrf

      <div class="mb-3">
        <label class="form-label">Event Name</label>
        <input type="text" name="name" class="form-control" >
      </div>

      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control"></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Price</label>
        <input type="number" name="price" step="0.01" class="form-control">
      </div>

      <div class="mb-3">
        <label class="form-label">Location</label>
        <input type="text" name="location" class="form-control">
      </div>

      <div class="mb-3">
        <label class="form-label">Image</label>
        <input type="file" name="img" class="form-control">
      </div>

      <div id="schedules-container">
        <h5>Schedules</h5>
        <div class="schedule-group mb-3 row">
          <div class="col">
            <input type="date" name="schedule_date[]" class="form-control">
          </div>
          <div class="col">
            <input type="time" name="schedule_time[]" class="form-control">
          </div>
          <div class="col-auto">
            <button type="button" class="btn btn-danger remove-schedule">X</button>
          </div>
        </div>
      </div>

      <button type="button" class="btn btn-secondary mb-3" id="addSchedule">Add Another Schedule</button>

      <button type="submit" class="btn btn-primary">Create Event</button>
    </form>
  </div>
</div>


@endsection
@push('script')
<script>
$(document).ready(function () {

   
    $('#addSchedule').on('click', function () {
        let scheduleHTML = `
        <div class="schedule-group mb-3 row">
            <div class="col">
                <input type="date" name="schedule_date[]" class="form-control">
            </div>
            <div class="col">
                <input type="time" name="schedule_time[]" class="form-control">
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-danger remove-schedule">X</button>
            </div>
        </div>`;
        $('#schedules-container').append(scheduleHTML);
    });

  
    $(document).on('click', '.remove-schedule', function () {
        $(this).closest('.schedule-group').remove();
    });

    // Form submission with AJAX
    $('#addEventForm').on('submit', function (e) {
        e.preventDefault();
        alert('submit');

        // Clear previous errors
        $('small.text-danger').text('');

        let formData = new FormData(this);

        $.ajax({
            url: "/events/store", 
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message
                }).then(() => {
                    window.location.reload();
                });
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        $(`#${key}Error`).text(value[0]); 
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Something went wrong!',
                        text: 'Please try again later.'
                    });
                }
            }
        });
    });
});
</script>

@endpush

