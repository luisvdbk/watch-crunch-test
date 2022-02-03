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

        $user->last_post_id = $post->id;
        $user->posts_count++;
        $user->save();
    }

    /**
     * Handle the Post "created" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function deleted(Post $post)
    {
        $user = $post->user;

        if ($lastPost = $user->posts()->latest('id')->first()) {
            $user->last_post_id = $lastPost->id;
        }

        $user->posts_count--;
        $user->save();
    }
}
