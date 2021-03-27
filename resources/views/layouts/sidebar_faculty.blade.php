<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route(config('app.f_slug').'.dashboard') }}" class="brand-link">
    <img src="{{ asset('assets/images/logo-icon.png') }}" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
  </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="@auth {{ asset('storage/users/'.Auth::user()->photo) }} @endauth" class="img-circle elevation-2" alt="">
        </div>
        <div class="info">
          <a href="{{ route(config('app.f_slug').'.dashboard') }}" class="d-block">@auth {{ Auth::user()->first_name.' '.Auth::user()->last_name }} @endauth</a>
          <span class="badge badge-warning">@auth FACULTY @endauth</span>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route(config('app.f_slug').'.dashboard') }}" class="nav-link {{ Request::routeIs(config('app.f_slug').'.dashboard') ? 'active' : ''}}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
              {{ __('Dashboard') }}
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route(config('app.f_slug').'.batches.index') }}" class="nav-link {{ Request::routeIs(config('app.f_slug').'.batches.*') ? 'active' : ''}}">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
              {{ __('Batches') }}
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route(config('app.f_slug').'.participants.index') }}" class="nav-link {{ Request::routeIs(config('app.f_slug').'.participants.*') ? 'active' : ''}}">
              <i class="nav-icon fas fa-users"></i>
              <p>
              {{ __('Participants') }}
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview {{ Request::routeIs(config('app.f_slug').'.assignments.*') ? 'menu-open' : ''}}">
            <a href="#" class="nav-link {{ Request::routeIs(config('app.f_slug').'.assignments.*') ? 'active' : ''}}">
              <i class="nav-icon fas fa-clipboard"></i>
              <p>
                {{ __('Assignments') }}
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route(config('app.f_slug').'.assignments.index') }}" class="nav-link {{ Request::routeIs(config('app.f_slug').'.assignments.index') ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('Manage Assignments') }}</p>
                </a>
              </li>
            </ul>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>