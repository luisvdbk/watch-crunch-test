<?php

namespace Tests\Feature\Models;

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;

class PostTest extends TestCase
{
    public function testItSavesPostMetaForUserAfterCreatingAPost()
    {
        $user = factory(User::class)->create();

        Carbon::setTestNow($testNow = now()->addDay());

        $postA = factory(Post::class)->create(['user_id' => $user->id]);
        $postB = factory(Post::class)->create(['user_id' => $user->id]);

        $user->refresh();

        $this->assertEquals($testNow->toDateTimeString(), $user->last_posted_at->toDateTimeString());
        $this->assertEquals($postB->id, $user->last_post_id);
        $this->assertEquals(2, $user->posts_count);
    }
}