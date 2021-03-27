
      <div class="setting_tabs mt-4">
        <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs(config('app.p_slug').'.account.profile') ? 'active' : ''}}" id="pills-account-tab" href="{{ route(config('app.p_slug').'.account.profile') }}" role="tab" aria-selected="true">Basic Info</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs(config('app.p_slug').'.account.password') ? 'active' : ''}}" id="pills-notification-tab" href="{{ route(config('app.p_slug').'.account.password') }}" role="tab" aria-selected="false">Change Password</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs(config('app.p_slug').'.account.photo') ? 'active' : ''}}" id="pills-privacy-tab" href="{{ route(config('app.p_slug').'.account.photo') }}" role="tab" aria-selected="false">Change Your Photo</a>
            </li>
        </ul>
    </div>