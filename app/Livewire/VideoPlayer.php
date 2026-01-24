<?php

namespace App\Livewire;

use Livewire\Component;

class VideoPlayer extends Component
{
    public $video;
    public $remainVideos;

    public function mount()
    {
        if ($this->video) {
            $this->remainVideos = $this->video->course->videos()->where('videos.id', '<>', $this->video->id)->get();
        }
    }

    public function render()
    {
        return view('livewire.video-player');
    }
}
