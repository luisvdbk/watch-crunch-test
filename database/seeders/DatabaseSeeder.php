<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        collect()->times(10)->each(function () {
            $user = factory(User::class)->create();
            $posts = factory(Post::class, rand(1, 5))->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
