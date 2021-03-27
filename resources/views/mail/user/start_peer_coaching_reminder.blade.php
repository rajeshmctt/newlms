@component('mail::message')
# Hello {{ $notifiable->first_name.' '.$notifiable->last_name }},

Hope you are enjoying the journey!

You have completed {{ $sessionsCount }} sessions and hope you have started your peer coaching, if not this is a gentle reminder for you to plan and complete the same. 

Note: If you block one hour with your peer – You will be doing 30 mins of coaching and your peer will be doing 30 mins of coaching. Both will get 30 mins of credit from a one-hour session. You are to complete 14 hours of Mandatory peer coaching (overall 28 sessions of 30 mins)

If you foresee any delays, please inform your faculty. 

Happy Learning!

Thank you,<br>
Team LMS<br>
{{ config('app.name') }}
@endcomponent
