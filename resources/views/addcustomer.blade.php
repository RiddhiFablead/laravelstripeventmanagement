@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="card shadow p-4 col-md-6 offset-md-3">
    <h4 class="mb-4 text-center">Add New User</h4>

    <form id="addUserForm" method="POST" action="{{ route('users.store') }}">
      @csrf

      <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" class="form-control" name="name" id="name">
        <small class="text-danger" id="nameError"></small>
      </div>

      <div class="mb-3">
        <label class="form-label">Email Address</label>
        <input type="email" class="form-control" name="email" id="email">
        <small class="text-danger" id="emailError"></small>
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" name="password" id="password">
        <small class="text-danger" id="passwordError"></small>
      </div>

      <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="text" class="form-control" name="phone" id="phone">
        <small class="text-danger" id="phoneError"></small>
      </div>

      <div class="mb-3">
        <label class="form-label">Address</label>
        <textarea class="form-control" name="address" id="address" rows="3"></textarea>
        <small class="text-danger" id="addressError"></small>
      </div>

      <div class="mb-3">
        <label class="form-label">Role</label>
        <select class="form-control" name="role" id="role">
          <option value="" disabled selected>Select Role</option>
          <option value="admin">Admin</option>
          <option value="user">user</option>
        </select>
        <small class="text-danger" id="roleError"></small>
      </div>

      <button type="submit" class="btn btn-primary w-100">Create User</button>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- SweetAlert2 -->

<script>
$(document).ready(function () {
  $('#addUserForm').on('submit', function (e) {
    e.preventDefault();

    const form = $(this);
    const url = form.attr('action');
    const formData = new FormData(this);

    // Clear previous errors
    ['name', 'email', 'password', 'phone', 'address', 'role'].forEach(field => {
      $('#' + field + 'Error').text('');
    });

    $.ajax({
      url: url,
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('input[name="_token"]').val()
      },
      success: function (response) {
        if (response.success) {
          Swal.fire('Success', response.message, 'success');
          form[0].reset();
        } else {
          Swal.fire('Error', response.message || 'Something went wrong.', 'error');
        }
      },
      error: function (xhr) {
        if (xhr.status === 422) {
          let errors = xhr.responseJSON.errors;
          $.each(errors, function (key, value) {
            $('#' + key + 'Error').text(value[0]);
          });
        } else {
          Swal.fire('Error', 'Unexpected error occurred.', 'error');
          console.error(xhr);
        }
      }
    });
  });
});
</script>

@endsection
