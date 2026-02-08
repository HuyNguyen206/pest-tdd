<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    @if($video)
        <h3>
            {{$video->title}}
        </h3>
        <p>
            {{$video->description}}
        </p>
        <span>
        {{$video->getReadableDuration()}}
    </span>
        <iframe src='https://player.vimeo.com/video/{{$video->vimeo_id}}' allowfullscreen></iframe>
    <div>
        <button class="p-2 y-4 border-2 border-cyan-800 bg-transparent" wire:click.prevent="toggleWatchedVideo({{$video->id}})">
            @if(auth()->user()->isWatchedVideo($video))
                Mark as uncompleted
            @else
                Mark as completed
            @endif

        </button>
    </div>

    @endif
    <div>
        @if($remainVideos)
            <ul>
                @foreach($remainVideos as $remainVideo)
                    <li>
                        <a href="{{route('courses.videos.index', [$video->course, $remainVideo])}}"> {{$remainVideo->title}}</a>
                    </li>
                @endforeach
            </ul>

        @endif
    </div>

</div>
