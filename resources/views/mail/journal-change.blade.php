@component('mail::message')
Journal Update Announcement.

Hello! We found out that you journal has been updated due to some circumstances.
If you want to check the change, please click the link that provided below.

@component('mail::button', ['url' => 'www.instagram.com'])
Check The Changes.
@endcomponent

Thanks,<br>
Monopoint
@endcomponent
