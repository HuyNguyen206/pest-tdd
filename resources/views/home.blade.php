<x-guest-layout :page-name="$pageName">
    @push('social-tags')
        <meta property="og:title" content="{{ $pageName }}">
        <meta property="og:description" content="Laracast is leading online learning plarform">
        <meta property="og:image" content="{{asset('images/black.jpeg')}}">
        <meta property="og:url" content="{{route('home')}}">
        <meta property="og:type" content="website">
    @endpush
<ul>
    @auth
        <li>
            <form action="{{route('logout')}}" method="post">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </li>
    @endauth
    @guest
            <li>
                <a href="{{route('login')}}">Login</a>
            </li>
            <li>
                <a href="register">Register</a>
            </li>
    @endguest

</ul>
    <hr>
@foreach($courses as $course)
    <h2>
        <a  class="font-bold underline" href="{{route('courses.show', $course)}}">
            {{$course->title}}
        </a>
    </h2>
    <p>
        {{$course->description}} @if($course->released_at) - <span>at {{$course->released_at->toDateTimeString()}}</span> @endif
    </p>
@endforeach
</x-guest-layout>
