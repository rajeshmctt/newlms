@extends('layouts.participant')

@section('script')
<script src="{{ asset('js/ctt.js') }}"></script>
@endsection

@section('style')
<style>
    .coaching-blog-loading{
        width:100%;
        background: #aaa;
        display: block;
        height: 250px;
        text-align: center;
        padding: 120px;
        font-weight: bold;
        font-size: 24px;
        color:#fff;
    }
    .card_dash_left1 h1 p{
        font-size: 22px;
        /* color: #333; */
        font-family: "Roboto", sans-serif;
        font-weight: 400;
        margin-bottom: 0 !important;
        text-align: left;
        margin-top: 0;
    }
</style>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h2 class="st_title"><i class="uil uil-user"></i> Hi {{ Auth::user()->first_name }}!</h2>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <a href="{{ route(config('app.p_slug').'.my_programs.index') }}" class="card_dash">
        <div class="card_dash_left">
            <h5>My Programs</h5>
        <h2>{{ $user->activeProgramsCount() }}</h2>
        </div>
        <div class="card_dash_right">
            <img src="{{ asset('assets/images/dashboard/programs.svg') }}" alt="" />
        </div>
        </a>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <a href="{{ route(config('app.p_slug').'.my_electives.index') }}" class="card_dash">
        <div class="card_dash_left">
            <h5>My Electives</h5>
            <h2>{{ $user->activeElectivesCount() }}</h2>
        </div>
        <div class="card_dash_right">
            <img src="{{ asset('assets/images/dashboard/electives.svg') }}" alt="" />
        </div>
        </a>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <a href="{{ route(config('app.p_slug').'.resources.my') }}" class="card_dash">
        <div class="card_dash_left">
            <h5>My Resources</h5>
            <h2>{{ $counts['resources'] }}</h2>
        </div>
        <div class="card_dash_right">
            <img src="{{ asset('assets/images/dashboard/resources.svg') }}" alt="" />
        </div>
        </a>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <a href="{{ route(config('app.p_slug').'.certificates.index') }}" class="card_dash">
        <div class="card_dash_left">
            <h5>My Certificates</h5>
            <h2>{{ $counts['certificates'] }}</h2>
        </div>
        <div class="card_dash_right">
            <img src="{{ asset('assets/images/dashboard/certificate.svg') }}" alt="" />
        </div>
        </a>
    </div>
    <div class="col-md-12">
        @if($optItNow)
        <a class="card_dash1" href="{{ route(config('app.p_slug').'.my_programs.batches.show', [$needToOptProgram->program->id, $needToOptProgram->id, 'tab' => 'electives']) }}">
        <div class="card_dash_left1">
            <i class="uil uil-book-alt"></i>
            <h1>You need to opt for {{ $needToOptProgram->zero_cost_electives - $needToOptProgram->elective_users_count }} elective(s) as part of your currently enrolled Program {{ $needToOptProgram->program->name }}. Kindly click here to complete the selection.</h1>
        </div>
        </a>
        @else
        @if($user->profileCompletion() < 50)
        <a class="card_dash1" href="{{ route(config('app.p_slug').'.account.profile') }}">
        <div class="card_dash_left1">
            <i class="uil uil-book-alt"></i>
            <h1>Please complete your profile details. Go to Settings.</h1>
        </div>
        </a>
        @else
        <a class="card_dash1">
        <div class="card_dash_left1">
            <i class="uil uil-book-alt"></i>
            <h1>Kindly follow {{ config('app.name') }} on Social Media (links in the footer)</h1>
        </div>
        </a>
        @endif
        @endif
    </div>
    <div class="col-md-12">
        <a class="card_dash1">
        <div class="card_dash_left1">
            <i class="fa fa-bullhorn"></i>
            <div class="owl-carousel updates_carousel owl-theme">
            @if(count($announcements))
            @foreach($announcements as $announcement)
            <div class="item">
                <h1>
                {!! $announcement->description !!}
                </h1>
            </div>
            @endforeach
            @else
            <div class="item">
                <h1>
                No announcements...
                </h1>
            </div>
            @endif
            </div>
        </div>
        </a>
    </div>
    </div>
    <div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="section3125 mt-50">
        <h4 class="item_title" style="width:100%;">Upcoming Programs
            <span class="float-right">
                <a href="{{ route(config('app.p_slug').'.dashboard', ['view' => 'grid']) }}" class="mr-2"><i class="fas fa-lg fa-th-large {{ !Request::get('view') || Request::get('view') == 'grid' ? 'text-theme2' : 'text-theme' }}"></i></a>
                <a href="{{ route(config('app.p_slug').'.dashboard', ['view' => 'list']) }}" class="mr-2"><i class="fas fa-lg fa-th-list {{ Request::get('view') == 'list' ? 'text-theme2' : 'text-theme' }}"></i></a>
            </span>
        </h4>
        <div class="la5lo1">
            <div class="owl-carousel1 courses_performance1 owl-theme1">
            
                <div class="row">
                    @if(count($upcomingProgramBatches))
                        @foreach($upcomingProgramBatches as $upcomingProgramBatch)
                            @include(config('app.p_slug').'.parts.upcoming_program')
                        @endforeach
                        <div class="col-xl-12 col-lg-12 col-md-12 text-center mb-5">
                            {{ $upcomingProgramBatches->withQueryString()->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        </div>
    </div>
    </div>
    <div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="section3125 mt-50" id="coaching-blog">
            <h4 class="item_title" style="width:100%;">Coaching Blog</h4>
            <coaching-blog-list></coaching-blog-list>
        </div>
    </div>
    </div>

@endsection
          