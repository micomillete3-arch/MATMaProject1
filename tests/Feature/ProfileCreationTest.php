<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_profile_is_created_when_a_user_is_created(): void
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
        ]);

        $this->assertNotNull($user->fresh()->profile);
    }
}
