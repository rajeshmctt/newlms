<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route(config('app.a_slug').'.dashboard') }}" class="brand-link">
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
          <a href="{{ route(config('app.a_slug').'.dashboard') }}" class="d-block">@auth {{ Auth::user()->first_name.' '.Auth::user()->last_name }} @endauth</a>
          <span class="badge badge-warning">@auth ADMIN @endauth</span>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route(config('app.a_slug').'.dashboard') }}" class="nav-link {{ Request::routeIs(config('app.a_slug').'.dashboard') ? 'active' : ''}}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
              {{ __('Dashboard') }}
              </p>
            </a>
          </li>
          
          <li class="nav-item has-treeview {{ Request::routeIs(config('app.a_slug').'.programs.*') || Request::routeIs(config('app.a_slug').'.batches.*') ? 'menu-open' : ''}}">
            <a href="#" class="nav-link {{ Request::routeIs(config('app.a_slug').'.programs.*') || Request::routeIs(config('app.a_slug').'.batches.*') ? 'active' : ''}}">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>
                {{ __('Programs & Batches') }}
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route(config('app.a_slug').'.programs.index') }}" class="nav-link {{ Request::routeIs(config('app.a_slug').'.programs.*') ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('Manage Programs') }}</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route(config('app.a_slug').'.batches.index') }}" class="nav-link {{ Request::routeIs(config('app.a_slug').'.batches.*') ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('Manage Batches') }}</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview {{ Request::routeIs(config('app.a_slug').'.faculties.*') ? 'menu-open' : ''}}">
            <a href="#" class="nav-link {{ Request::routeIs(config('app.a_slug').'.faculties.*') ? 'active' : ''}}">
              <i class="nav-icon fas fa-chalkboard-teacher"></i>
              <p>
                {{ __('Faculty') }}
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route(config('app.a_slug').'.faculties.index') }}" class="nav-link {{ Request::routeIs(config('app.a_slug').'.faculties.*') ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('Manage Faculty') }}</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview {{ Request::routeIs(config('app.a_slug').'.participants.*') ? 'menu-open' : ''}}">
            <a href="#" class="nav-link {{ Request::routeIs(config('app.a_slug').'.participants.*') ? 'active' : ''}}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                {{ __('Participants') }}
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route(config('app.a_slug').'.participants.index') }}" class="nav-link {{ Request::routeIs(config('app.a_slug').'.participants.*') ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('Manage Participants') }}</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview {{ Request::routeIs(config('app.a_slug').'.resources.*') ? 'menu-open' : ''}}">
            <a href="#" class="nav-link {{ Request::routeIs(config('app.a_slug').'.resources.*') ? 'active' : ''}}">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                {{ __('Resources') }}
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route(config('app.a_slug').'.resources.index') }}" class="nav-link {{ Request::routeIs(config('app.a_slug').'.resources.index') ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('Manage Resources') }}</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview {{ 
            Request::routeIs(config('app.a_slug').'.reports.*') 
            ? 'menu-open' : ''}}">
            <a href="#" class="nav-link {{ 
              Request::routeIs(config('app.a_slug').'.reports.*') 
              ? 'active' : ''}}">
              <i class="nav-icon fas fa-database"></i>
              <p>
                {{ __('Reports') }}
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route(config('app.a_slug').'.reports.list_of_participants') }}" class="nav-link {{ Request::routeIs(config('app.a_slug').'.reports.list_of_participants') ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('List of Participants') }}</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{ route(config('app.a_slug').'.certificates.index') }}" class="nav-link {{ Request::routeIs(config('app.a_slug').'.certificates.*') ? 'active' : ''}}">
              <i class="nav-icon fas fa-handshake"></i>
              <p>
              {{ __('Certificates') }}
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview {{ 
            Request::routeIs(config('app.a_slug').'.feedbacks.*') 
            ? 'menu-open' : ''}}">
            <a href="#" class="nav-link {{ 
              Request::routeIs(config('app.a_slug').'.feedbacks.*') 
              ? 'active' : ''}}">
              <i class="nav-icon fas fa-thumbs-up"></i>
              <p>
                {{ __('Approvals') }}
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route(config('app.a_slug').'.feedbacks.index') }}" class="nav-link {{ Request::routeIs(config('app.a_slug').'.feedbacks.*') ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('Feedbacks') }}</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview {{ 
            Request::routeIs(config('app.a_slug').'.countries.*') 
            || Request::routeIs(config('app.a_slug').'.locations.*') 
            || Request::routeIs(config('app.a_slug').'.agreements.*') 
            || Request::routeIs(config('app.a_slug').'.certification-levels.*') 
            || Request::routeIs(config('app.a_slug').'.currencies.*') 
            || Request::routeIs(config('app.a_slug').'.labels.*') 
            || Request::routeIs(config('app.a_slug').'.global-announcements.*') 
            ? 'menu-open' : ''}}">
            <a href="#" class="nav-link {{ 
              Request::routeIs(config('app.a_slug').'.countries.*') 
              || Request::routeIs(config('app.a_slug').'.locations.*') 
              || Request::routeIs(config('app.a_slug').'.agreements.*') 
              || Request::routeIs(config('app.a_slug').'.certification-levels.*') 
              || Request::routeIs(config('app.a_slug').'.currencies.*') 
              || Request::routeIs(config('app.a_slug').'.labels.*') 
              || Request::routeIs(config('app.a_slug').'.global-announcements.*') 
              ? 'active' : ''}}">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                {{ __('Configurations') }}
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route(config('app.a_slug').'.countries.index') }}" class="nav-link {{ Request::routeIs(config('app.a_slug').'.countries.*') ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('Countries') }}</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route(config('app.a_slug').'.locations.index') }}" class="nav-link {{ Request::routeIs(config('app.a_slug').'.locations.*') ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('Locations') }}</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route(config('app.a_slug').'.agreements.index') }}" class="nav-link {{ Request::routeIs(config('app.a_slug').'.agreements.*') ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('Agreements') }}</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route(config('app.a_slug').'.certification-levels.index') }}" class="nav-link {{ Request::routeIs(config('app.a_slug').'.certification-levels.*') ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('Certification Levels') }}</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route(config('app.a_slug').'.currencies.index') }}" class="nav-link {{ Request::routeIs(config('app.a_slug').'.currencies.*') ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('Currencies') }}</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route(config('app.a_slug').'.labels.index') }}" class="nav-link {{ Request::routeIs(config('app.a_slug').'.labels.*') ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('Labels') }}</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route(config('app.a_slug').'.global-announcements.index') }}" class="nav-link {{ Request::routeIs(config('app.a_slug').'.global-announcements.*') ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ __('Global Announcements') }}</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{ route(config('app.a_slug').'.account.password') }}" class="nav-link {{ Request::routeIs(config('app.a_slug').'.account.password') ? 'active' : ''}}">
              <i class="nav-icon fas fa-key"></i>
              <p>
              {{ __('Change Password') }}
              </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>