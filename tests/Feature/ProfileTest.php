<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    /**
     * @test
     */
    public function it_renders_the_profile_view()
    {
        $user = factory(User::class)->create([
            'username' => 'davidgrey',
        ]);

        $this
            ->get(route('profile', 'davidgrey'))
            ->assertOk()
            ->assertViewIs('profile');
    }

    /**
     * @test
     * @dataProvider usernamesProvider
     */
    public function identifies_profile_when_using_different_casings(string $usernameParam)
    {
        $user = factory(User::class)->create([
            'username' => 'davidgrey',
        ]);

        $this
            ->get(route('profile', $usernameParam))
            ->assertOk()
            ->assertViewIs('profile');
    }

    public function usernamesProvider()
    {
        return [
            ['davidgrey'],
            ['davidGrey'],
            ['DavidGrey'],
            ['daVidGreY'],
        ];
    }
}
