<?php

namespace Tests\Feature\Models;

use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * @test
     */
    public function it_saves_post_meta_for_user_after_creating_a_post()
    {
        $user = factory(User::class)->create();

        $postA = factory(Post::class)->create(['user_id' => $user->id]);
        $postB = factory(Post::class)->create(['user_id' => $user->id]);

        $user->refresh();

        $this->assertEquals($postB->id, $user->last_post_id);
        $this->assertEquals(2, $user->posts_count);
    }

    /**
     * @test
     */
    public function when_deleting_post_it_updates_user_post_meta()
    {
        $user = factory(User::class)->create();

        $postA = factory(Post::class)->create(['user_id' => $user->id]);
        $postB = factory(Post::class)->create(['user_id' => $user->id]);

        $user->refresh();

        $this->assertEquals($postB->id, $user->last_post_id);
        $this->assertEquals(2, $user->posts_count);

        $postB->delete();

        $user->refresh();

        $this->assertEquals($postA->id, $user->last_post_id);
        $this->assertEquals(1, $user->posts_count);
    }
}
