<?php

namespace Tests\Feature\Actions;

use App\Actions\GetLessActiveUsers;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetLessActiveUsersTest extends TestCase
{
    /**
     * @test
     */
    public function includes_users_without_posts_in_last_7_days()
    {
        $userA = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $userC = factory(User::class)->create();
        $userD = factory(User::class)->create();

        $postA = factory(Post::class)->create([
            'created_at' => now()->subDays(8),
            'user_id' => $userA->id,
        ]);

        $postB = factory(Post::class)->create([
            'created_at' => now()->subDays(5),
            'user_id' => $userB->id,
        ]);

        $postC = factory(Post::class)->create([
            'created_at' => now()->subDays(9),
            'user_id' => $userC->id,
        ]);

        $postD = factory(Post::class)->create([
            'created_at' => now()->subDays(3),
            'user_id' => $userD->id,
        ]);

        $users = app(GetLessActiveUsers::class)->handle();
        $usersById = $users->pluck('id');

        $this->assertCount(2, $users);
        $this->assertTrue($usersById->contains($userA->id));
        $this->assertTrue($usersById->contains($userC->id));
    }
}
