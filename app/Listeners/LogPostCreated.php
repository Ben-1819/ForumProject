<?php

namespace App\Listeners;

use App\Events\PostCreated;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogPostCreated
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PostCreated $event): void
    {
        log::info("Post created");
        log::info("Post title: {title}", ["title" => $event->post->title]);
        log::info("Post description: {description}", ["description" => $event->post->description]);
    }
}
