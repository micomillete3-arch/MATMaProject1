<?php

namespace Tests\Feature;

use App\Models\UserAccounts;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TeacherManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_see_teacher_actions_in_the_list(): void
    {
        $admin = UserAccounts::create([
            'username' => 'admincrud',
            'email' => 'admincrud@example.com',
            'password' => Hash::make('Admin12345'),
            'role' => UserAccounts::ROLE_ADMIN,
            'is_active' => 1,
            'must_change_password' => false,
        ]);

        $teacher = UserAccounts::create([
            'username' => 'teachercrud',
            'email' => 'teachercrud@example.com',
            'password' => Hash::make('Teacher12345'),
            'role' => UserAccounts::ROLE_TEACHER,
            'is_active' => 1,
            'must_change_password' => true,
        ]);

        $response = $this->actingAs($admin)->get(route('teachers.create'));

        $response->assertOk();
        $response->assertSee(route('teachers.show', $teacher->id), false);
        $response->assertSee(route('teachers.edit', $teacher->id), false);
        $response->assertSee(route('teachers.destroy', $teacher->id), false);
    }

    public function test_admin_can_view_update_and_delete_a_teacher(): void
    {
        $admin = UserAccounts::create([
            'username' => 'adminmanage',
            'email' => 'adminmanage@example.com',
            'password' => Hash::make('Admin12345'),
            'role' => UserAccounts::ROLE_ADMIN,
            'is_active' => 1,
            'must_change_password' => false,
        ]);

        $teacher = UserAccounts::create([
            'username' => 'teacherold',
            'email' => 'teacherold@example.com',
            'password' => Hash::make('Teacher12345'),
            'role' => UserAccounts::ROLE_TEACHER,
            'is_active' => 1,
            'must_change_password' => false,
        ]);

        $this->actingAs($admin)
            ->get(route('teachers.show', $teacher->id))
            ->assertOk()
            ->assertSee('teacherold');

        $this->actingAs($admin)
            ->put(route('teachers.update', $teacher->id), [
                'username' => 'teachernew',
                'email' => 'teachernew@example.com',
                'password' => 'Teacher67890',
            ])
            ->assertRedirect(route('teachers.show', $teacher->id));

        $this->assertDatabaseHas('user_accounts', [
            'id' => $teacher->id,
            'username' => 'teachernew',
            'email' => 'teachernew@example.com',
            'role' => UserAccounts::ROLE_TEACHER,
        ]);

        $this->assertTrue((bool) UserAccounts::findOrFail($teacher->id)->must_change_password);

        $this->actingAs($admin)
            ->delete(route('teachers.destroy', $teacher->id))
            ->assertRedirect(route('teachers.create'));

        $this->assertDatabaseMissing('user_accounts', [
            'id' => $teacher->id,
        ]);
    }
}
