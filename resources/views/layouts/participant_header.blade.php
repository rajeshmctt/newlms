<!-- Header Start -->
<header class="header clearfix">
  <button type="button" id="toggleMenu" class="toggle_menu">
    <i class="uil uil-bars"></i>
  </button>
  <button id="collapse_menu" class="collapse_menu">
    <i class="uil uil-bars collapse_menu--icon"></i>
    <span class="collapse_menu--label"></span>
  </button>
  <div class="main_logo" id="logo">
    <a href="{{ route('dashboard') }}"><img src="{{ asset('assets/images/logo.png') }}" alt="" /></a>
    <a href="{{ route('dashboard') }}"
      ><img class="logo-inverse" src="{{ asset('assets/images/logo.png') }}" alt=""
    /></a>
  </div>
  
  <div class="header_right">
    <ul>
      <li class="ui dropdown d-none">
        <a href="#" class="option_links"
          ><i class="uil uil-bell"></i><span class="noti_count">3</span></a
        >
        <div class="menu dropdown_mn">
          <a href="#" class="channel_my item">
            <div class="profile_link">
              <img src="{{ asset('assets/images/left-imgs/img-1.jpg') }}" alt="" />
              <div class="pd_content">
                <h6>Rock William</h6>
                <p>
                  Like Your Comment On Video
                  <strong>How to create sidebar menu</strong>.
                </p>
                <span class="nm_time">2 min ago</span>
              </div>
            </div>
          </a>
          <a class="vbm_btn" href="{{ route('dashboard') }}"
            >View All <i class="uil uil-arrow-right"></i
          ></a>
        </div>
      </li>
      <li class="ui dropdown">
      <span class="opts_account">Last Login: {{ Auth::user()->last_logged_in_at ? Auth::user()->last_logged_in_at->format('D d M, Y | h:i A') : '-' }} (IST)</span>
      </li>
      <li class="ui dropdown">
        <a href="#" class="opts_account">
          <img src="{{ asset('storage/users/'.Auth::user()->photo) }}" alt="" />
        </a>
        <div class="menu dropdown_account">
          <div class="channel_my">
            <div class="profile_link">
              <img src="{{ asset('storage/users/'.Auth::user()->photo) }}" alt="" />
              <div class="pd_content">
                <div class="rhte85">
                  <h6 class="mb-auto">{{ Auth::user()->first_name.' '.Auth::user()->last_name }}</h6>
                  <div title="Profile" class="badge badge-primary ml-2">
                  {{ $user->profileCompletion() }}%
                  </div>
                </div>
                <span>{{ Auth::user()->email }}</span>
                <br>
                <span>
                  <span class="vdt15">{{ $user->activeProgramsCount() }} Programs</span> |
                  <span class="vdt15">{{ $user->activeElectivesCount() }} Electives</span>
                </span>
              </div>
            </div>
            <hr>
            <div class="">

              @php($currentCredentials = $user->currentCredentials->pluck('name')->toArray())

              <dl style="margin-bottom:0;">
                <dt>Current Credential:</dt>
                <dd class="text-left">{{ count($currentCredentials) ? implode(',', $user->currentCredentials->pluck('name')->toArray()) : '-' }}</dd>
                <dt>Role:</dt>
                <dd class="text-left">{{ $user->currentRole ? $user->currentRole->name : '-' }}</dd>
                <dt>Function:</dt>
                <dd class="text-left">{{ $user->CurrentFunction ? $user->CurrentFunction->name : '-' }}</dd>
                <dt>Company Name:</dt>
                <dd class="text-left">{{ $user->current_organisation_name ? $user->current_organisation_name : '-' }}</dd>
              </dl>
              
            </div>

          </div>
          <div class="night_mode_switch__btn">
            <a href="#" id="night-mode" class="btn-night-mode">
              <i class="uil uil-moon"></i> Night mode
              <span class="btn-night-mode-switch">
                <span class="uk-switch-button"></span>
              </span>
            </a>
          </div>
          <a href="{{ route(config('app.p_slug').'.account.profile') }}" class="item channel_item">Settings</a>
          <a href="{{ route('logout') }}" class="item channel_item">Sign Out</a>
        </div>
      </li>
    </ul>
  </div>
</header>
<!-- Header End -->