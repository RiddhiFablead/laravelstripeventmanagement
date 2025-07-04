@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="card shadow p-4 col-md-6 offset-md-3">
    <h4 class="mb-4 text-center">Change Password</h4>

    <form id="changePasswordForm" method="POST">
      @csrf

      <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" class="form-control" name="email" value="{{ session('email') }}" readonly>
      </div>

      <div class="mb-3">
        <label for="oldpassword" class="form-label">Old Password</label>
        <input type="password" class="form-control" name="oldpassword" id="oldpassword">
        <small id="oldPasswordError" class="text-danger"></small>
      </div>

      <div class="mb-3">
        <label for="newpassword" class="form-label">New Password</label>
        <input type="password" class="form-control" name="newpassword" id="newpassword">
        <small id="newPasswordError" class="text-danger"></small>
      </div>

      <div class="mb-3">
        <label for="confirmpassword" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" name="confirmpassword" id="confirmpassword">
        <small id="confirmPasswordError" class="text-danger"></small>
      </div>

      <button type="submit" class="btn btn-primary w-100">Change Password</button>
    </form>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  $(document).ready(function () {
    $('#changePasswordForm').on('submit', function (e) {
      e.preventDefault();

     
      $('#oldPasswordError').text('');
      $('#newPasswordError').text('');
      $('#confirmPasswordError').text('');

      const email = $('input[name="email"]').val().trim();
      const oldpassword = $('#oldpassword').val().trim();
      const newpassword = $('#newpassword').val().trim();
      const confirmpassword = $('#confirmpassword').val().trim();

      let hasError = false;

      if (!oldpassword) {
        $('#oldPasswordError').text('Old password is required.');
        hasError = true;
      }

      if (!newpassword) {
        $('#newPasswordError').text('New password is required.');
        hasError = true;
      } else if (newpassword.length < 6) {
        $('#newPasswordError').text('Password must be at least 6 characters.');
        hasError = true;
      }

      if (newpassword !== confirmpassword) {
        $('#confirmPasswordError').text('Passwords do not match.');
        hasError = true;
      }

      if (hasError) return;

    
      $.ajax({
        url: "{{ route('password.update') }}",
        method: "POST",
        data: {
          _token: "{{ csrf_token() }}",
          email: email,
          oldpassword: oldpassword,
          newpassword: newpassword,
          confirmpassword: confirmpassword,
        },
        success: function (res) {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: res.message || 'Password changed successfully!',
            confirmButtonColor: '#3085d6',
          }).then(() => {
            $('#changePasswordForm')[0].reset();
          });
        },
        error: function (xhr) {
          let errorMsg = 'Something went wrong';
          if (xhr.status === 422) {
            const errors = xhr.responseJSON.errors;
            if (errors.oldpassword) $('#oldPasswordError').text(errors.oldpassword[0]);
            if (errors.newpassword) $('#newPasswordError').text(errors.newpassword[0]);
            if (errors.confirmpassword) $('#confirmPasswordError').text(errors.confirmpassword[0]);
            return;
          }

          if (xhr.responseJSON?.message) {
            errorMsg = xhr.responseJSON.message;
          }

          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: errorMsg,
            confirmButtonColor: '#d33',
          });
        }
      });
    });
  });
</script>
@endsection
