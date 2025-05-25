   <!-- Topbar -->
   <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">




       <!-- Topbar Navbar -->
       <ul class="navbar-nav ml-auto">







           <!-- Nav Item - User Information -->
           <li class="nav-item dropdown no-arrow">
               <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                   <span class="mr-2 d-none d-lg-inline text-gray-600 small">Muhammad Ishaq</span>
                   <img class="img-profile rounded-circle" src="assets/images/undraw_profile.svg">
               </a>
               <!-- Dropdown - User Information -->
               <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                   <a class="dropdown-item" href="{{ route('user.profile') }}">
                       <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                       Profile
                   </a>
                   <a class="dropdown-item" href="{{ route('settings.index') }}">
                       <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                       Settings
                   </a>

                   <div class="dropdown-divider"></div>
                   <form action="{{ route('logout')  }}" method="post">
                       @csrf

                       <div style="margin-left: 25px;">
                           <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                           <input type="submit" value="logout"
                               style="border: none; background-color:white; color:black; margin-left:-5px; ">
                       </div>


                   </form>
               </div>
           </li>

       </ul>

   </nav>
   <!-- End of Topbar -->