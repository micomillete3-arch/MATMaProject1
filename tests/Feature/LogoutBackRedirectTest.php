<?php

namespace Tests\Feature;

use App\Models\UserAccounts;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LogoutBackRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_pages_are_not_cached(): void
    {
        $teacher = UserAccounts::create([
            'username' => 'teachercheck',
            'email' => 'teachercheck@example.com',
            'password' => Hash::make('Teacher12345'),
            'role' => UserAccounts::ROLE_TEACHER,
            'is_active' => 1,
            'must_change_password' => false,
        ]);

        $response = $this->actingAs($teacher)->get(route('teacher.dashboard'));

        $response->assertOk();
        $response->assertHeader('Pragma', 'no-cache');
        $response->assertHeader('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
        $this->assertStringContainsString('no-store', (string) $response->headers->get('Cache-Control'));
        $this->assertStringContainsString('no-cache', (string) $response->headers->get('Cache-Control'));
        $this->assertStringContainsString('must-revalidate', (string) $response->headers->get('Cache-Control'));
        $this->assertStringContainsString('max-age=0', (string) $response->headers->get('Cache-Control'));
    }

    public function test_back_to_protected_page_redirects_to_login_after_logout(): void
    {
        $teacher = UserAccounts::create([
            'username' => 'teacherlogout',
            'email' => 'teacherlogout@example.com',
            'password' => Hash::make('Teacher12345'),
            'role' => UserAccounts::ROLE_TEACHER,
            'is_active' => 1,
            'must_change_password' => false,
        ]);

        $this->actingAs($teacher)
            ->post(route('logout'))
            ->assertRedirect(route('student.login'));

        $this->assertGuest();

        $this->get(route('teacher.dashboard'))
            ->assertRedirect(route('student.login'));
    }
}
