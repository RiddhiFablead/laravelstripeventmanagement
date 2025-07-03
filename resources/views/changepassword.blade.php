@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="card shadow p-4 col-md-6 offset-md-3">
    <h4 class="mb-4 text-center">Change Password</h4>

    
    @if(session('success'))
      <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

   
    <form id="changePasswordForm" method="POST" action="{{ route('password.update') }}">
      @csrf

      <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" class="form-control" name="email" id="email"
               value="{{ session('user_email') }}" readonly>
      </div>

      <div class="mb-3">
        <label for="oldpassword" class="form-label">Old Password</label>
        <input type="password" class="form-control" name="oldpassword" id="oldpassword">
        <div class="text-danger small" id="oldPasswordError"></div>
      </div>

      <div class="mb-3">
        <label for="newpassword" class="form-label">New Password</label>
        <input type="password" class="form-control" name="newpassword" id="newpassword">
        <div class="text-danger small" id="newPasswordError"></div>
      </div>

      <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm New Password</label>
        <input type="password" class="form-control" name="newpassword_confirmation" id="confirm_password">
        <div class="text-danger small" id="confirmPasswordError"></div>
      </div>

      <button type="submit" class="btn btn-primary w-100">Change Password</button>
    </form>

  </div>
</div>


<script>
  document.getElementById('changePasswordForm').addEventListener('submit', function (e) {
    let hasError = false;

    document.getElementById('oldPasswordError').textContent = '';
    document.getElementById('newPasswordError').textContent = '';
    document.getElementById('confirmPasswordError').textContent = '';

    const oldPass = document.getElementById('oldpassword').value.trim();
    const newPass = document.getElementById('newpassword').value.trim();
    const confirmPass = document.getElementById('confirm_password').value.trim();

    if (!oldPass) {
      document.getElementById('oldPasswordError').textContent = 'Old password is required.';
      hasError = true;
    }

    if (!newPass) {
      document.getElementById('newPasswordError').textContent = 'New password is required.';
      hasError = true;
    } else if (newPass.length < 6) {
      document.getElementById('newPasswordError').textContent = 'Password must be at least 6 characters.';
      hasError = true;
    }

    if (newPass !== confirmPass) {
      document.getElementById('confirmPasswordError').textContent = 'Passwords do not match.';
      hasError = true;
    }

    if (hasError) {
      e.preventDefault();
    }
  });
</script>
@endsection
