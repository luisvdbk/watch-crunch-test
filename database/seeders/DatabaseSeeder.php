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
        collect()->times(20)->each(function () {
            $user = factory(User::class)->create();

            collect()->times(rand(1, 2))->each(function () use ($user) {
                factory(Post::class, )->create([
                    'user_id' => $user->id,
                    'created_at' => now()->subDays(rand(5, 10)),
                ]);
            });
        });
    }
}
