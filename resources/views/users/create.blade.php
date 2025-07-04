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
          <option value="admin">admin</option>
          <option value="user">user</option>
        </select>
        <small class="text-danger" id="roleError"></small>
      </div>

      <button type="submit" class="btn btn-primary w-100">Create User</button>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('addUserForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);
  const url = form.getAttribute('action');

 
  ['name', 'email', 'password', 'phone', 'address', 'role'].forEach(field => {
    document.getElementById(field + 'Error').textContent = '';
  });

  fetch(url, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
      'Accept': 'application/json'
    },
    body: formData
  })
  .then(response => {
    if (response.status === 422) {
      return response.json().then(data => {
        const errors = data.errors;
        for (const key in errors) {
          if (errors.hasOwnProperty(key)) {
            const errorElement = document.getElementById(`${key}Error`);
            if (errorElement) {
              errorElement.textContent = errors[key][0];
            }
          }
        }
        throw new Error('Validation failed');
      });
    }
    return response.json();
  })
  .then(data => {
    if (data.success) {
      Swal.fire('Success', data.message, 'success');
      form.reset();
    } else {
      Swal.fire('Error', data.message || 'Something went wrong.', 'error');
    }
  })
  .catch(error => {
    if (error.message !== 'Validation failed') {
      console.error(error);
      Swal.fire('Error', 'Unexpected error occurred.', 'error');
    }
  });
});
</script>
@endsection
