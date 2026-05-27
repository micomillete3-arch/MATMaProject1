<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagesProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_profile_page_handles_missing_users(): void
    {
        $response = $this->get('/user_profile');

        $response->assertOk();
        $response->assertSee('No bio yet.');
        $response->assertDontSee('Profile Bio');
    }

    public function test_user_profile_page_shows_the_user_name_and_bio(): void
    {
        $user = User::factory()->create();
        $user->profile()->update([
            'bio' => 'just do it mico',
        ]);

        $response = $this->get('/user_profile');

        $response->assertOk();
        $response->assertSee($user->name);
        $response->assertSee('just do it mico');
        $response->assertSeeInOrder([
            $user->name,
            'just do it mico',
        ]);
        $response->assertDontSee('Profile Bio');
    }
}
