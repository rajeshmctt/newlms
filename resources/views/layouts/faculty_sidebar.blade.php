
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
              <a href="{{ route('dashboard') }}" class="menu--link {{ Request::routeIs(config('app.f_slug').'.dashboard') ? 'active' : ''}}" title="Dashboard">
                <i class="uil uil-home-alt menu--icon"></i>
                <span class="menu--label">Dashboard</span>
              </a>
            </li>
            <li class="menu--item menu--item__has_sub_menu {{ Request::routeIs(config('app.f_slug').'.faculty-batches.*') || Request::routeIs(config('app.f_slug').'.mentor-coach-batches.*') ? 'menu--subitens__opened' : ''}}">
              <label class="menu--link {{ Request::routeIs(config('app.f_slug').'.faculty-batches.*') || Request::routeIs(config('app.f_slug').'.mentor-coach-batches.*') ? 'active' : ''}}" title="Batches">
                <i class='uil uil-layers menu--icon'></i>
                <span class="menu--label">Batches</span>
                <i class="fas fa-sort-down"></i>
              </label>
              <ul class="sub_menu">
                <li class="sub_menu--item">
                  <a href="{{ route(config('app.f_slug').'.faculty-batches.index') }}" class="sub_menu--link {{ Request::routeIs(config('app.f_slug').'.faculty-batches.*') ? 'active' : ''}}">As Faculty</a>
                </li>
                <li class="sub_menu--item">
                  <a href="{{ route(config('app.f_slug').'.mentor-coach-batches.index') }}" class="sub_menu--link {{ Request::routeIs(config('app.f_slug').'.mentor-coach-batches.*') ? 'active' : ''}}">As Mentor Coach</a>
                </li>
              </ul>
            </li>
            <li class="menu--item menu--item__has_sub_menu {{ Request::routeIs(config('app.f_slug').'.faculty-participants.*') || Request::routeIs(config('app.f_slug').'.mentor-coach-participants.*') ? 'menu--subitens__opened' : ''}}">
              <label class="menu--link {{ Request::routeIs(config('app.f_slug').'.faculty-participants.*') || Request::routeIs(config('app.f_slug').'.mentor-coach-participants.*') ? 'active' : ''}}" title="Participants">
                <i class='uil uil-users-alt menu--icon'></i>
                <span class="menu--label">Participants</span>
                <i class="fas fa-sort-down"></i>
              </label>
              <ul class="sub_menu">
                <li class="sub_menu--item">
                  <a href="{{ route(config('app.f_slug').'.faculty-participants.index') }}" class="sub_menu--link {{ Request::routeIs(config('app.f_slug').'.faculty-participants.*') ? 'active' : ''}}">As Faculty</a>
                </li>
                <li class="sub_menu--item">
                  <a href="{{ route(config('app.f_slug').'.mentor-coach-participants.index') }}" class="sub_menu--link {{ Request::routeIs(config('app.f_slug').'.mentor-coach-participants.*') ? 'active' : ''}}">As Mentor Coach</a>
                </li>
              </ul>
            </li>
            <li class="menu--item menu--item__has_sub_menu {{ Request::routeIs(config('app.f_slug').'.faculty-resources.*') || Request::routeIs(config('app.f_slug').'.mentor-coach-resources.*') ? 'menu--subitens__opened' : ''}}">
              <label class="menu--link {{ Request::routeIs(config('app.f_slug').'.faculty-resources.*') || Request::routeIs(config('app.f_slug').'.mentor-coach-resources.*') ? 'active' : ''}}" title="Resources">
                <i class='uil uil-book-alt menu--icon'></i>
                <span class="menu--label">Resources</span>
                <i class="fas fa-sort-down"></i>
              </label>
              <ul class="sub_menu">
                <li class="sub_menu--item">
                  <a href="{{ route(config('app.f_slug').'.faculty-resources.index') }}" class="sub_menu--link {{ Request::routeIs(config('app.f_slug').'.faculty-resources.*') ? 'active' : ''}}">As Faculty</a>
                </li>
                <li class="sub_menu--item">
                  <a href="{{ route(config('app.f_slug').'.mentor-coach-resources.index') }}" class="sub_menu--link {{ Request::routeIs(config('app.f_slug').'.mentor-coach-resources.*') ? 'active' : ''}}">As Mentor Coach</a>
                </li>
              </ul>
            </li>
            <li class="menu--item menu--item__has_sub_menu {{ Request::routeIs(config('app.f_slug').'.faculty-approvals.*') || Request::routeIs(config('app.f_slug').'.mentor-coach-approvals.*') ? 'menu--subitens__opened' : ''}}">
              <label class="menu--link {{ Request::routeIs(config('app.f_slug').'.faculty-approvals.*') || Request::routeIs(config('app.f_slug').'.mentor-coach-approvals.*') ? 'active' : ''}}" title="Approvals">
                <i class='uil uil-book-alt menu--icon'></i>
                <span class="menu--label">Approvals</span>
                <i class="fas fa-sort-down"></i>
              </label>
              <ul class="sub_menu">
                <li class="sub_menu--item">
                  <a href="{{ route(config('app.f_slug').'.faculty-approvals.index') }}" class="sub_menu--link {{ Request::routeIs(config('app.f_slug').'.faculty-approvals.*') ? 'active' : ''}}">As Faculty</a>
                </li>
                <li class="sub_menu--item">
                  <a href="{{ route(config('app.f_slug').'.mentor-coach-approvals.index') }}" class="sub_menu--link {{ Request::routeIs(config('app.f_slug').'.mentor-coach-approvals.index') ? 'active' : ''}}">As Mentor Coach</a>
                </li>
              </ul>
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