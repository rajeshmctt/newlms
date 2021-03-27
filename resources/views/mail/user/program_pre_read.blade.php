@component('mail::message')
# Hello {{ $notifiable->first_name.' '.$notifiable->last_name }},

We are delighted to have you on-board for the Program: {{ $batch->program->name }}.

As part of this course, we have uploaded certain course content as pre-read / pre-requisite to the LMS. It is important that you go through the content before the course / session starts to make the sessions more worthy and effective.

Thank you,<br>
Team LMS<br>
{{ config('app.name') }}
@endcomponent
