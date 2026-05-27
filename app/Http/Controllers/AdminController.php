<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\UserAccounts;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        /** @var UserAccounts $user */
        $user = auth()->user();

        $stats = [
            'students' => Student::count(),
            'teachers' => UserAccounts::where('role', UserAccounts::ROLE_TEACHER)->count(),
            'admins' => UserAccounts::where('role', UserAccounts::ROLE_ADMIN)->count(),
        ];

        $latestStudents = Student::with(['degree', 'userAccount'])
            ->latest()
            ->take(5)
            ->get();

        $teachers = UserAccounts::where('role', UserAccounts::ROLE_TEACHER)
            ->latest()
            ->take(5)
            ->get();

        return view('adminDashboard', compact('user', 'stats', 'latestStudents', 'teachers'));
    }

    public function createTeacher(): View
    {
        $teachers = $this->teacherQuery()
            ->orderBy('username')
            ->get();

        return view('addTeacher', compact('teachers'));
    }

    public function listTeachers(Request $request)
    {
        $teachers = $this->teacherQuery()
            ->orderBy('username')
            ->get();

        if ($request->ajax() || $request->expectsJson()) {
            return view('partials.teachers_list', compact('teachers'));
        }

        return view('addTeacher', compact('teachers'));
    }

    public function storeTeacher(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'username' => 'required|string|min:3|max:255|unique:user_accounts,username',
            'email' => 'required|email|max:255|unique:user_accounts,email',
            'password' => 'required|string|min:8|max:255',
        ]);

        $teacher = UserAccounts::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => UserAccounts::ROLE_TEACHER,
            'is_active' => 1,
            'must_change_password' => true,
        ]);

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'teacher' => $teacher,
                'redirect_url' => url('/teachers'),
            ]);
        }

        return redirect()
            ->route('teachers.create')
            ->with('status', 'Teacher account for '.$teacher->username.' created successfully.');
    }

    public function showTeacher(int $id): View
    {
        $teacher = $this->findTeacher($id);

        return view('teacherDetails', compact('teacher'));
    }

    public function editTeacher(int $id): View
    {
        $teacher = $this->findTeacher($id);

        return view('editTeacher', compact('teacher'));
    }

    public function updateTeacher(Request $request, int $id): JsonResponse|RedirectResponse
    {
        $teacher = $this->findTeacher($id);

        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('user_accounts', 'username')->ignore($teacher->id),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('user_accounts', 'email')->ignore($teacher->id),
            ],
            'password' => 'nullable|string|min:8|max:255',
        ]);

        $teacherData = [
            'username' => $validated['username'],
            'email' => $validated['email'],
            'role' => UserAccounts::ROLE_TEACHER,
            'is_active' => 1,
        ];

        if (! empty($validated['password'])) {
            $teacherData['password'] = Hash::make($validated['password']);
            $teacherData['must_change_password'] = true;
        }

        $teacher->update($teacherData);

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'teacher' => $teacher,
                'redirect_url' => url('/teachers'),
            ]);
        }

        return redirect()
            ->route('teachers.show', $teacher->id)
            ->with('success', 'Teacher account updated successfully.');
    }

    public function destroyTeacher(Request $request, int $id): JsonResponse|RedirectResponse
    {
        $teacher = $this->findTeacher($id);
        $username = $teacher->username;

        $teacher->delete();

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'redirect_url' => url('/teachers'),
            ]);
        }

        return redirect()
            ->route('teachers.create')
            ->with('status', 'Teacher account for '.$username.' deleted successfully.');
    }

    private function teacherQuery()
    {
        return UserAccounts::where('role', UserAccounts::ROLE_TEACHER);
    }

    private function findTeacher(int $id): UserAccounts
    {
        return $this->teacherQuery()->findOrFail($id);
    }
}
