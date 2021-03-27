
<style>
  .sub_menu--link.active{
    color: #1d3557 !important;
    background: #a8dadc;
  }
  .menu--subitens__opened .menu--link{
    color: #fff;
  }
</style>

    <!-- Left Sidebar Start -->
    <nav class="vertical_nav">
      <div class="left_section menu_left" id="js-menu">
        <div class="left_section">
          <ul>
            <li class="menu--item">
              <a href="{{ route('dashboard') }}" class="menu--link {{ Request::routeIs(config('app.p_slug').'.dashboard') ? 'active' : ''}}" title="Dashboard">
                <i class="uil uil-home-alt menu--icon"></i>
                <span class="menu--label">Dashboard</span>
              </a>
            </li>
            <li class="menu--item menu--item__has_sub_menu {{ Request::routeIs(config('app.p_slug').'.programs.*') || Request::routeIs(config('app.p_slug').'.my_programs.*') ? 'menu--subitens__opened' : ''}}">
              <label class="menu--link {{ Request::routeIs(config('app.p_slug').'.programs.*') || Request::routeIs(config('app.p_slug').'.my_programs.*') ? 'active' : ''}}" title="Programs">
                <i class='uil uil-layers menu--icon'></i>
                <span class="menu--label">Programs</span>
                <i class="fas fa-sort-down"></i>
              </label>
              <ul class="sub_menu">
                <li class="sub_menu--item">
                  <a href="{{ route(config('app.p_slug').'.programs.index') }}" class="sub_menu--link {{ Request::routeIs(config('app.p_slug').'.programs.*') ? 'active' : ''}}">All Programs</a>
                </li>
                <li class="sub_menu--item">
                  <a href="{{ route(config('app.p_slug').'.my_programs.index') }}" class="sub_menu--link {{ Request::routeIs(config('app.p_slug').'.my_programs.*') ? 'active' : ''}}">My Programs</a>
                </li>
              </ul>
            </li>
            <li class="menu--item menu--item__has_sub_menu {{ Request::routeIs(config('app.p_slug').'.electives.*') || Request::routeIs(config('app.p_slug').'.my_electives.*') ? 'menu--subitens__opened' : ''}}">
              <label class="menu--link {{ Request::routeIs(config('app.p_slug').'.electives.*') || Request::routeIs(config('app.p_slug').'.my_electives.*') ? 'active' : ''}}" title="Electives">
                <i class='uil uil-file-alt menu--icon'></i>
                <span class="menu--label">Electives</span>
                <i class="fas fa-sort-down"></i>
              </label>
              <ul class="sub_menu">
                <li class="sub_menu--item">
                  <a href="{{ route(config('app.p_slug').'.electives.index') }}" class="sub_menu--link {{ Request::routeIs(config('app.p_slug').'.electives.*') ? 'active' : ''}}">All Electives</a>
                </li>
                <li class="sub_menu--item">
                  <a href="{{ route(config('app.p_slug').'.my_electives.index') }}" class="sub_menu--link {{ Request::routeIs(config('app.p_slug').'.my_electives.*') ? 'active' : ''}}">My Electives</a>
                </li>
              </ul>
            </li>
            <li class="menu--item menu--item__has_sub_menu {{ Request::routeIs(config('app.p_slug').'.resources.*') ? 'menu--subitens__opened' : ''}}">
              <label class="menu--link {{ Request::routeIs(config('app.p_slug').'.resources.*') ? 'active' : ''}}" title="Resources">
                <i class='uil uil-book-alt menu--icon'></i>
                <span class="menu--label">Resources</span>
                <i class="fas fa-sort-down"></i>
              </label>
              <ul class="sub_menu">
                <li class="sub_menu--item">
                  <a href="{{ route(config('app.p_slug').'.resources.index') }}" class="sub_menu--link {{ Request::routeIs(config('app.p_slug').'.resources.index') ? 'active' : ''}}">All Resources</a>
                </li>
                <li class="sub_menu--item">
                  <a href="{{ route(config('app.p_slug').'.resources.my') }}" class="sub_menu--link {{ Request::routeIs(config('app.p_slug').'.resources.my') ? 'active' : ''}}">My Resources</a>
                </li>
              </ul>
            </li>
            <li class="menu--item">
              <a href="{{ route(config('app.p_slug').'.certificates.index') }}" class="menu--link {{ Request::routeIs(config('app.p_slug').'.certificates.*') ? 'active' : ''}}" title="My Certificates">
                <i class='uil uil-award menu--icon'></i>
                <span class="menu--label">My Certificates</span>
              </a>
            </li>
          </ul>
        </div>
        <!-- <div class="left_section pt-2">
				<ul>
					<li class="menu--item">
						<a href="setting.html" class="menu--link" title="Setting">
							<i class='uil uil-cog menu--icon'></i>
							<span class="menu--label">Setting</span>
						</a>
					</li>
					<li class="menu--item">
						<a href="feedback.html" class="menu--link" title="Send Feedback">
							<i class='uil uil-comment-alt-exclamation menu--icon'></i>
							<span class="menu--label">Send Feedback</span>
						</a>
					</li>
				</ul>
			</div> -->
      </div>
    </nav>
    <!-- Left Sidebar End -->