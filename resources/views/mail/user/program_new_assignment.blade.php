@component('mail::message')
# Hello {{ $notifiable->first_name.' '.$notifiable->last_name }},

A new assignment has been uploaded by the faculty member for your program: {{ $batch->program->name }}.

You are requested to submit your response within the stipulated time.

Thank you,<br>
Team LMS<br>
{{ config('app.name') }}
@endcomponent
