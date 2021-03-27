@component('mail::message')
# Hello {{ $notifiable->first_name.' '.$notifiable->last_name }},

Hope you are enjoying the journey!

Your Blog {{ $blogCount }} is due for submission on {{ $assignment->due_date }}. Hope you have been able to work on it if not this is a gentle reminder for you to complete it. 

Please log onto LMS and under Resources --> Search Bar --> Type “Guidance for Blogs”. The document will support you further. If you foresee any delays, please inform your faculty.

Happy Learning!

Thank you,<br>
Team LMS<br>
{{ config('app.name') }}
@endcomponent
