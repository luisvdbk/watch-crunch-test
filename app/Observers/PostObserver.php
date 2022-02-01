<?php

namespace App\Observers;

use App\Models\Post;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function created(Post $post)
    {
        $user = $post->user;

        $user->last_posted_at = now();
        $user->last_post_id = $post->id;
        $user->posts_count++;
        $user->save();
    }
}
