<div>
                {{$video->title}}
    <p>
        {{$video->description}}
    </p>
    <span>
        {{$video->getReadableDuration()}}
    </span>
    <iframe src='https://player.vimeo.com/video/{{$video->vimeo_id}}' allowfullscreen></iframe>
</div>
