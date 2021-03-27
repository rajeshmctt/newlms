@component('mail::message')
# Hello {{ $notifiable->first_name.' '.$notifiable->last_name }},

Hope you are enjoying the journey!

@if($blogCount == 1)

Your 1st 1x1 with your mentor coach is due. Please use this link to block time with your mentor coach - <Link> 

No preparation is required just block and meet with your Mentor Coach.

@elseif($blogCount == 2)

Your 2nd 1x1 with your mentor coach is due. Please use this link to block time with your mentor coach - <Link>

Hope you have been able to work on the topics that was discussed in the 1st 1x1. Be ready to share your reflection of the same. 

@elseif($blogCount == 3)

Your 3rd 1x1 with your mentor coach is due. 

In this session you are to typically take a recording of your coaching to be shared with your mentor coach for review. Hope you have the recording ready. If not please use this reminder to work on a recording before you block time with mentor coach. Be ready to share your assessment and reflection of the same. 

Please use this link to block time with your mentor coach - <Link>

@endif

Happy Learning!

Thank you,<br>
Team LMS<br>
{{ config('app.name') }}
@endcomponent
