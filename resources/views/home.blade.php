
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
@foreach($courses as $course)
    <h2>
        {{$course->title}}
    </h2>
    <p>
        {{$course->description}} @if($course->released_at) - <span>at {{$course->released_at->toDateTimeString()}}</span> @endif
    </p>
@endforeach
