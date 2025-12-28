<h2>
    {{$course->title}}
</h2>

<p>{{$course->description}}</p>
<p>{{$course->tagline}}</p>
<ul>
    @foreach($course->learning as $learn)
        <li>{{$learn}}</li>
    @endforeach
</ul>
<span>Total videos: {{$course->videos_count}} videos</span>
<img src="{{asset($course->image)}}" alt="">

