<x-mail::message>
        # Welcome to {{ config('app.name') }}!

    We're thrilled to have you join our community. Here's what you can do next:

    - Complete your profile to help others discover you
    - Share your first post with the community
    - Connect with other users who share your interests

    If you have any questions, feel free to reply to this email. We're here to help!

 <x-mail::button :url="''">
        Complete Your Profile
    </x-mail::button>



Thanks,<br>
    The {{ config('app.name') }} Team
</x-mail::message>




