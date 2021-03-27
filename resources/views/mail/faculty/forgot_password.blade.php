@component('mail::message')
# Hello {{ $notifiable->first_name.' '.$notifiable->last_name }},

Please click on the below Link to rest your pasword.

<a href="{{ url('/') }}">{{ url('/') }}</a>

The link is valid for 24 hours.

Thank you,<br>
Team LMS<br>
{{ config('app.name') }}
@endcomponent
