<x-mail::message>
    # Thanks for purchase course {{$course->title}}

    If this is your first purchase, the new account was already created for you. Enjoy!

    <x-mail::button url="{{route('login')}}">
        Login
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
