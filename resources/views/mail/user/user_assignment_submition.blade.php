@component('mail::message')
# Hello {{ $notifiable->first_name.' '.$notifiable->last_name }},

{{ $pUser->first_name.' '.$pUser->last_name }} has uploaded his/ her assignment response. You may retrieve the same by logging in to the LMS as a faculty member.

File Submitted: {{ $userAssignment->document_name ? $userAssignment->document_name : 'None' }}

Thank you,<br>
Team LMS<br>
{{ config('app.name') }}
@endcomponent
