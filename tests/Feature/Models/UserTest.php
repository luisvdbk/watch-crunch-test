<?php

namespace Tests\Feature\Models;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * @test
     */
    public function it_saves_lowercased_version_of_the_username()
    {
        $userA = factory(User::class)->create([
            'username' => 'davidGrey',
        ]);

        $this->assertEquals('davidGrey', $userA->username);
        $this->assertEquals('davidgrey', $userA->username_lowercased);

        $userA->username = 'DavidGrey';
        $userA->save();

        $this->assertEquals('DavidGrey', $userA->username);
        $this->assertEquals('davidgrey', $userA->username_lowercased);
    }
}
