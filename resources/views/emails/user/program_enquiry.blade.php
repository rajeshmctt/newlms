@component('mail::message')
# Hello CTT Team,

The following enquiry has been made through the LMS portal -

Participant Name: {{ $user->first_name }} {{ $user->last_name }}

Mobile - {{ $user->phone }}

Email - {{ $user->email }}

Program enquired for - {{ $batch->program->name }} | {{ $batch->start_date->format('d/m/Y') }}

Thank you,<br>
Team LMS<br>
{{ config('app.name') }}
@endcomponent
