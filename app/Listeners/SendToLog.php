<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

use App\Events\PostEvent;
use App\Model\PostLog;
use App\Model\Post;
use Auth;

class SendToLog
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PostEvent $event)
    {
        $data = Post::find($event->post->id);
        if ($data) {
            $now = now('Asia/Jakarta')->diffInMinutes($data->posted_at);
            if ($now < 1) {
                $message = "Created";
            } else {
                $message = "Update";
            }
        }else {
            $message = "Delete";
        }

        Log::info("Post was $message");

        $saveLog = new PostLog;
        $saveLog->user_id = Auth::user()->id;
        $saveLog->status = $message;
        $saveLog->save();
    }
}
