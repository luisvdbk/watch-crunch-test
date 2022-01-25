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
            'username' => 'davidGrey',
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
    public function identifies_profile_when_using_different_casings(string $stored, string $param)
    {
        $user = factory(User::class)->create([
            'username' => $stored,
        ]);

        $this
            ->get(route('profile', $param))
            ->assertOk()
            ->assertViewIs('profile');
    }

    public function usernamesProvider()
    {
        return [
            ['daVidGreY', 'davidgrey'],
            ['DavidGrey', 'davidGrey'],
            ['davidgrey', 'DavidGrey'],
            ['davidGrey', 'daVidGreY'],
        ];
    }
}
