@component('mail::message')
# Hello {{ $notifiable->first_name.' '.$notifiable->last_name }},

@php( $mins = 60 )

A hearty and warm welcome to the {{ $batch->program->name }} by Coach-To-Transformation! Starting on {{ $batch->start_date }}.

We do hope that you find what you are looking for during this journey. It is a journey of self-awareness, new friendships and moving into a space where you can help others in a structured process. 

Each of you in the cohort is investing time, energy and money into this program and it is very important that you attend the program in its totality. 
Every session, peer coaching and self-study that we make you go through is an important element. 
Your complete participation is expected, not just for you, but as a way of showcasing respect towards others in the group.

This is an online session with global participants dialing in from different countries your local timings and logistics are as follows; 

<ul>
    <li>Session timings will be {{ $batch->start_time }} with a 10-minute break in between decided by the mentor coach. </li>
    <li>There will also be a meeting invite that you will receive blocking your time for {{ $batch->sessions_count }} for {{ $mins/60 }} hours every {{ $batch->frequency }} week.</li>
    <li>We will be using ZOOM video-conferencing application for the program. You may download the same here</li>
    <li>Once online you are expected to be on-video at all times and on mute. Whenever you need to speak you may unmute and share.</li>
    <li>Please ensure to have internet speeds of more than 10 mbps so that video streaming can be smoother, along with a working head/earphone with microphone</li>
    <li>Connecting on laptop is recommended at all times (unless during travel to connect on zoom mobile app) </li>
    <li>Feel free to have your favorite cup of (tea/coffee) and snack during the session </li>
</ul>

Our Commitment to Climate Change: We are committed to impacting climate change and hence we request you to make any contribution from your side during this program – not printing any material that is not required.

About LMS: We are proud to share access to CTT Learning Management System to you. Through LMS you will be able to keep track of your assignments during the program, get access to recordings of your sessions, learning resources that have been collated over past several years for your learning, access our webinar videos on various topics from well-established external leaders and coaches who bring their own topic from around the world on leadership and coaching and much more...

Access LMS here - <a href="{{ url('/') }}">{{ url('/') }}</a>

Username - {{ $notifiable->email }}

Password - 12345 (please change password after logging in first time)

We at CTT are looking forward to doing this journey with you. We really hope that you get what you are looking for. 
Please reach out to me if you need any clarifications as a reply to this email or you can call me @ +918971727000

See you soon!!

Thank you,<br>
Team LMS<br>
{{ config('app.name') }}
@endcomponent
