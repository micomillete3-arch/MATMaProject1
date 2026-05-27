<?php

namespace Tests\Feature;

use App\Models\UserAccounts;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ForcePasswordChangeTest extends TestCase
{
    use RefreshDatabase;

    public function test_first_login_redirects_user_to_change_password_page(): void
    {
        $user = UserAccounts::create([
            'username' => 'firstlogin',
            'email' => 'firstlogin@example.com',
            'password' => Hash::make('Password123'),
            'role' => UserAccounts::ROLE_TEACHER,
            'is_active' => 1,
            'must_change_password' => true,
        ]);

        $response = $this->post(route('student.login.submit'), [
            'username' => 'firstlogin',
            'password' => 'Password123',
        ]);

        $response->assertRedirect(route('student.password.change'));
        $response->assertSessionHas('password_change_user_id', $user->id);
        $this->assertGuest();
    }

    public function test_user_with_updated_password_reaches_dashboard(): void
    {
        $user = UserAccounts::create([
            'username' => 'teacherready',
            'email' => 'teacherready@example.com',
            'password' => Hash::make('Password123'),
            'role' => UserAccounts::ROLE_TEACHER,
            'is_active' => 1,
            'must_change_password' => false,
        ]);

        $response = $this->post(route('student.login.submit'), [
            'username' => 'teacherready',
            'password' => 'Password123',
        ]);

        $response->assertRedirect(route('teacher.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_is_redirected_back_to_change_password_when_visiting_another_uri(): void
    {
        UserAccounts::create([
            'username' => 'lockedfirstlogin',
            'email' => 'lockedfirstlogin@example.com',
            'password' => Hash::make('Password123'),
            'role' => UserAccounts::ROLE_TEACHER,
            'is_active' => 1,
            'must_change_password' => true,
        ]);

        $this->post(route('student.login.submit'), [
            'username' => 'lockedfirstlogin',
            'password' => 'Password123',
        ])->assertRedirect(route('student.password.change'));

        $this->get(route('aboutUs'))
            ->assertRedirect(route('student.password.change'));

        $this->get(route('student.login'))
            ->assertRedirect(route('student.password.change'));
    }
}
