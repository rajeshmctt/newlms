@component('mail::message')
# Hello {{ $notifiable->first_name.' '.$notifiable->last_name }},

Hope you are enjoying the journey!

Your assignment {{ $assignment->name }} is due on {{ $assignment->due_date }}. Hope you have been able to work on it if not this is a gentle reminder for you to complete it. If you foresee any delays, please inform your faculty. Happy Learning!

Thank you,<br>
Team LMS<br>
{{ config('app.name') }}
@endcomponent
