<?php

namespace Tests\Feature\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * @test
     */
    public function it_saves_username_in_lowercase()
    {
        $userA = factory(User::class)->create([
            'username' => 'davidGrey',
        ]);

        $this->assertEquals('davidgrey', $userA->username);

        $userA->username = 'DavidGrey';
        $userA->save();

        $this->assertEquals('davidgrey', $userA->username);
    }
}
