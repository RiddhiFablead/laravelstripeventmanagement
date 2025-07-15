    <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
</head>
<body>

<section class="vh-100" style="background-color: #9A616D;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="{{ asset('assets/img/login.jpg') }}" alt="login form"
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

                <form method="POST" id="loginForm"> 
                  @csrf

                  <div class="d-flex align-items-center mb-3 pb-1">
                    <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                    <span class="h1 fw-bold mb-0">Login</span>
                  </div>

                  <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your account</h5>

                  <div class="form-outline mb-4">
                    <label class="form-label" for="email">Email address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           class="form-control form-control-lg" required autofocus />
                  </div>

                  <div class="form-outline mb-4">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password"
                           class="form-control form-control-lg" required />
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

<script>
  $(document).ready(function () {
    $('#loginForm').on('submit', function (e) {
      e.preventDefault();

      $.ajax({
        url: "{{ route('login') }}", 
        type: "POST",
        data: $(this).serialize(),
         dataType: "json",
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function (response) {
        
          
          Swal.fire({
            icon: 'success',
            title: 'Login successful',
            showConfirmButton: false,
            timer: 1500
          });
          if(response.role == 'admin'){
            
            
            setTimeout(function () {
            window.location.href = response.redirect_url || '/dashboard';
          }, 1500);
          }else{
            setTimeout(function () {
            window.location.href = response.redirect_url || '/customerdashboard';
          }, 1500);
          }

          
        },
        error: function (xhr) {
          let errorMessage = 'An error occurred';
          if (xhr.status === 422 && xhr.responseJSON.errors) {
            const errors = xhr.responseJSON.errors;
            errorMessage = Object.values(errors).flat().join('<br>');
          } else if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
          }

          Swal.fire({
            icon: 'error',
            title: 'Login Failed',
            html: errorMessage
          });
        }
      });
    });
  });
</script>

</body>
</html>
