<?php

namespace App\Actions;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Spatie\QueueableAction\QueueableAction;

class GetTopUsers
{
    use QueueableAction;

    public const DAYS_TO_CONSIDER = 7;
    public const MIN_POSTS_REQUIRED = 10;
    public const CACHE_KEY = 'top_users';

    public function execute(): array
    {
        /** @var \Illuminate\Database\Eloquent\Collection */
        $topUsers = Cache::remember(self::CACHE_KEY, now()->endOfDay(), function () {
            $usersThatPostedEnoughWithinLastDays = Post::select('user_id')
                ->where('created_at', '>=', now()->subDays(self::DAYS_TO_CONSIDER)->startOfDay())
                ->groupBy('user_id')
                ->havingRaw('COUNT(*) >= ?', [self::MIN_POSTS_REQUIRED]);

            return User::with('lastPost')->whereIn('id', $usersThatPostedEnoughWithinLastDays)->get();
        });

        /**
         * we could also make this return a dto that holds this structured data
         */
        return $topUsers->map(function (User $user) {
            return [
                'username' => $user->username,
                'created_posts_count' => $user->posts_count,
                'last_post_title' => $user->lastPost->title,
            ];
        })->toArray();
    }
}
