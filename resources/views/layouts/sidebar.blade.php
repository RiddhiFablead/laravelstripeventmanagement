 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

     <!-- Sidebar - Brand -->
     <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
         <div class="sidebar-brand-icon rotate-n-15">
             <i class="fa-solid fa-wand-magic-sparkles" style="color: #e7ecf3;"></i>
         </div>
         <div class="sidebar-brand-text mx-3">Luxe Moments</div>
     </a>

     <!-- Divider -->
     <hr class="sidebar-divider my-0">

     <!-- Nav Item - Dashboard -->
     {{-- <li class="nav-item active">
         <a class="nav-link" href="index.html">
             <i class="fas fa-fw fa-tachometer-alt"></i>
             <span>Dashboard</span></a>
     </li> --}}

     <!-- Divider -->
     <hr class="sidebar-divider">

     <!-- Heading -->
     {{-- <div class="sidebar-heading">
         Interface
     </div> --}}
     <!-- Nav Item - Pages Collapse Menu -->
     {{-- <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
             aria-expanded="true" aria-controls="collapseTwo">
             <i class="fa-solid fa-gear" style="color: #e7ecf3;"></i>
             <span>Authentications</span>
         </a>
         <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">

                 <a class="collapse-item" href="{{ route('login') }}">Login</a>
                 <a class="collapse-item" href="{{ route('changepassword') }}">Change Password</a>
             </div>
         </div>
     </li> --}}

     @if (session('role') == 'admin')
         <li class="nav-item">
             <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                 aria-expanded="true" aria-controls="collapseUtilities">
                 <i class="fa-solid fa-user" style="color: #e7ecf3;"></i>
                 <span>Customer</span>
             </a>
             <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                 data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">
                     <h6 class="collapse-header">Custom Utilities:</h6>
                     <a class="collapse-item" href="{{ route('users.create') }}">Add Customer</a>
                     <a class="collapse-item" href="{{ route('users.index') }}">Display Customer</a>


                 </div>
             </div>
         </li>

         <!-- Divider -->
         <hr class="sidebar-divider">

         <!-- Heading -->
         <div class="sidebar-heading">
             Addons
         </div>

         <!-- Nav Item - Pages Collapse Menu -->
         <li class="nav-item">
             <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                 aria-expanded="true" aria-controls="collapsePages">
                 <i class="fa-solid fa-calendar-days" style="color: #e7ecf3;"></i>
                 <span>Event</span>
             </a>
             <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">

                     <a class="collapse-item" href="{{ route('events.create') }}">Add Event</a>
                     <a class="collapse-item" href="{{ route('events.index') }}">Show Event</a>

                 </div>
             </div>
         </li>
     @endif
      @if (session('role') == 'user')
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
             aria-expanded="true" aria-controls="collapseUtilities">
             <i class="fa-solid fa-user" style="color: #e7ecf3;"></i>
             <span>Events</span>
         </a>
         <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
             data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <h6 class="collapse-header">Custom Utilities:</h6>
                 <a class="collapse-item" href="{{ route('customer.event') }}">All Events</a>




             </div>
         </div>
     </li>
     @endif


     <!-- Divider -->
     <hr class="sidebar-divider d-none d-md-block">
 </ul>
