<?php

namespace Tests\Feature\Actions;

use App\Actions\GetTopUsers;
use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class GetTopUsersTest extends TestCase
{
    /**
     * @test
     */
    public function includes_users_which_have_at_least_10_posts_in_last_7_days()
    {
        $userA = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $userC = factory(User::class)->create();

        /** userA posts */
        factory(Post::class, 9)->create([
            'created_at' => now()->subDays(6),
            'user_id' => $userA->id,
        ]);
        $lastPostA = factory(Post::class)->create([
            'created_at' => now()->subDays(6),
            'user_id' => $userA->id,
        ]);

        /** userB posts */
        factory(Post::class, 5)->create([
            'created_at' => now()->subDays(2),
            'user_id' => $userB->id,
        ]);
        factory(Post::class, 6)->create([
            'created_at' => now()->subDays(6),
            'user_id' => $userB->id,
        ]);
        $lastPostB = factory(Post::class)->create([
            'created_at' => now()->subDays(8),
            'user_id' => $userB->id,
        ]);

        /** userC posts */
        factory(Post::class, 9)->create([
            'created_at' => now()->subDays(5),
            'user_id' => $userC->id,
        ]);
        factory(Post::class, 2)->create([
            'created_at' => now()->subDays(11),
            'user_id' => $userC->id,
        ]);

        $topUsers = app(GetTopUsers::class)->execute();

        $this->assertCount(2, $topUsers);

        $this->assertEquals($userA->username, data_get($topUsers, '0.username'));
        $this->assertEquals(10, data_get($topUsers, '0.created_posts_count'));
        $this->assertEquals($lastPostA->title, data_get($topUsers, '0.last_post_title'));

        $this->assertEquals($userB->username, data_get($topUsers, '1.username'));
        $this->assertEquals(12, data_get($topUsers, '1.created_posts_count'));
        $this->assertEquals($lastPostB->title, data_get($topUsers, '1.last_post_title'));
    }
}
