<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>

  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<section class="vh-100" style="background-color: #9A616D;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="assets/img/login.jpg" alt="login form"
                   class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
            </div>
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">

              
                @if(session('error'))
                  <div class="alert alert-danger">
                    {{ session('error') }}
                  </div>
                @endif

              
                @if($errors->any())
                  <div class="alert alert-danger">
                    <ul class="mb-0">
                      @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif

                <form method="POST" action="{{ route('login') }}" id="loginForm">
                  @csrf

                  <div class="d-flex align-items-center mb-3 pb-1">
                    <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                    <span class="h1 fw-bold mb-0">Login</span>
                  </div>

                  <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your account</h5>

                  <div class="form-outline mb-4">
                    <label class="form-label" for="email">Email address</label>
                    <input type="email" id="email" name="email"
                           class="form-control form-control-lg"
                           value="{{ old('email') }}"  />
                    <span id="emailError" class="text-danger small"></span>
                  </div>

                  <div class="form-outline mb-4">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password"
                           class="form-control form-control-lg"  />
                    <span id="passwordError" class="text-danger small"></span>
                  </div>

                  <div class="pt-1 mb-4">
                    <button class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
                  </div>

                  <a class="small text-muted" href="#">Forgot password?</a>
                  <p class="mb-5 pb-lg-2" style="color: #393f81;">
                    Don't have an account?
                    <a href="#" style="color: #393f81;">Register here</a>
                  </p>
                  <a href="#" class="small text-muted">Terms of use</a>
                  <a href="#" class="small text-muted">Privacy policy</a>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('loginForm');

  form.addEventListener('submit', function (e) {
    let hasError = false;

    document.getElementById('emailError').textContent = '';
    document.getElementById('passwordError').textContent = '';

    const email = form.email.value.trim();
    const password = form.password.value;

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!email) {
      document.getElementById('emailError').textContent = 'Email is required.';
      hasError = true;
    } else if (!emailRegex.test(email)) {
      document.getElementById('emailError').textContent = 'Invalid email format.';
      hasError = true;
    }

    if (!password) {
      document.getElementById('passwordError').textContent = 'Password is required.';
      hasError = true;
    } else if (password.length < 6) {
      document.getElementById('passwordError').textContent = 'Password must be at least 6 characters.';
      hasError = true;
    }

    if (hasError) {
      e.preventDefault();
    }
  });
});
</script>

</body>
</html>
