<div>
    @if($video)
        <b>
            {{$video->title}}
        </b>
        <p>
            {{$video->description}}
        </p>
        <span>
        {{$video->getReadableDuration()}}
    </span>
        <iframe src='https://player.vimeo.com/video/{{$video->vimeo_id}}' allowfullscreen></iframe>
   <a href="#" wire:click.prevent="toggleWatchedVideo">
       @if(auth()->user()->isWatchedVideo($video))
           Mark as uncompleted
       @else
           Mark as completed
       @endif

   </a>
    @endif

    @if($remainVideos)
        @foreach($remainVideos as $remainVideo)
                <a href="{{route('courses.videos.index', [$video->course, $remainVideo])}}"> {{$remainVideo->title}}</a>
        @endforeach
    @endif
</div>
