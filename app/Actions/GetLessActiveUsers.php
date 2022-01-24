<?php

namespace App\Actions;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class GetLessActiveUsers
{
    public const DAYS_TO_CONSIDER = 7;
    public const CACHE_KEY = 'less_active_users';

    public function handle(): Collection
    {
        return Cache::remember(self::CACHE_KEY, now()->endOfDay(), function () {
            $postsWithinLastWeekByUserId = Post::select('user_id')
                ->where('created_at', '>=', now()->subDays(self::DAYS_TO_CONSIDER)->endOfDay())
                ->groupBy('user_id');

            /**
             * Depending on the usecase we might want to ->limit/->take certain number of users
             * in case we have too many on the dbs
             */
            return User::whereNotIn('id', $postsWithinLastWeekByUserId)->get();
        });
    }
}
