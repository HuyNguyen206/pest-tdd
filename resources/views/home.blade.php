@foreach($courses as $course)
    <h2>
        {{$course->title}}
    </h2>
    <p>
        {{$course->description}} @if($course->released_at) - <span>at {{$course->released_at->toDateTimeString()}}</span> @endif
    </p>
@endforeach
