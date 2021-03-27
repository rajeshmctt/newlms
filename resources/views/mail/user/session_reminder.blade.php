@component('mail::message')
# Hello {{ $notifiable->first_name.' '.$notifiable->last_name }},

Your session no {{ $session->session_no }} for Program: {{ $session->batch->program->name }} is scheduled for tomorrow. Hope you have been able to work on your pre-read and post-read. Below are the link details for you to connect. 

<a href="{{ route(config('app.p_slug').'.my_programs.batches.show', [$session->batch->program->id, $session->batch->id]) }}">{{ route(config('app.p_slug').'.my_programs.batches.show', [$session->batch->program->id, $session->batch->id]) }}</a>

Thank you,<br>
Team LMS<br>
{{ config('app.name') }}
@endcomponent
