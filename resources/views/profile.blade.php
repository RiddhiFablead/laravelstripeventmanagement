@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <h2>User Profile</h2>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <form method="POST" action="{{ route('profile.update') }}" id="profileForm">
    @csrf

    <div class="mb-3">
      <label for="name" class="form-label">Full Name</label>
      <input type="text" class="form-control" id="name" name="name" value="{{ old('name', session('name')) }}">
      <div class="text-danger small" id="nameError"></div>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email Address</label>
      <input type="email" class="form-control" id="email" name="email" value="{{ old('email', session('email')) }}">
      <div class="text-danger small" id="emailError"></div>
    </div>

    <div class="mb-3">
      <label for="role" class="form-label">Role</label>
      <input type="text" class="form-control" id="role" name="role" value="{{ session('role') }}" readonly>
    </div>

    <div class="mb-3">
      <label for="phone" class="form-label">Phone Number</label>
      <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
      <div class="text-danger small" id="phoneError"></div>
    </div>

    <div class="mb-3">
      <label for="address" class="form-label">Address</label>
      <textarea class="form-control" id="address" name="address" rows="3">{{ old('address') }}</textarea>
      <div class="text-danger small" id="addressError"></div>
    </div>

    <button type="submit" class="btn btn-primary">Update Profile</button>
  </form>
</div>

    
<script>
document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('profileForm').addEventListener('submit', function (e) {
    let hasError = false;

    document.getElementById('nameError').textContent = '';
    document.getElementById('emailError').textContent = '';
    document.getElementById('phoneError').textContent = '';
    document.getElementById('addressError').textContent = '';

    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const address = document.getElementById('address').value.trim();

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phoneRegex = /^[0-9]{10}$/;

    if (!name) {
      document.getElementById('nameError').textContent = 'Name is required.';
      hasError = true;
    }

    if (!email) {
      document.getElementById('emailError').textContent = 'Email is required.';
      hasError = true;
    } else if (!emailRegex.test(email)) {
      document.getElementById('emailError').textContent = 'Invalid email format.';
      hasError = true;
    }

    if (!phone) {
      document.getElementById('phoneError').textContent = 'Phone number is required.';
      hasError = true;
    } else if (!phoneRegex.test(phone)) {
      document.getElementById('phoneError').textContent = 'Enter a valid 10-digit phone number.';
      hasError = true;
    }

    if (!address) {
      document.getElementById('addressError').textContent = 'Address is required.';
      hasError = true;
    }

    if (hasError) {
      e.preventDefault();
    }
  });
});
</script>
@endsection
