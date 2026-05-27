<?php

namespace App\Http\Controllers;

use App\Models\Degree;
use App\Models\Student;
use App\Models\UserAccounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function homiePage()
    {
        return view('homiePage');
    }

    public function aboutUs()
    {
        return view('aboutUs');
    }

    public function manageStudents()
    {
        $students = Student::with(['degree', 'userAccount'])->paginate(5);
        $degrees = Degree::orderBy('id')->get();

        return view('studentss', compact('students', 'degrees'));
    }

    public function index(Request $request)
    {
        if ($request->is('students')) {
            $students = Student::with(['degree', 'userAccount'])
                ->latest('id')
                ->get();

            return view('partials.students_list', compact('students'));
        }

        return $this->manageStudents();
    }

    public function create()
    {
        $degrees = Degree::orderBy('id')->get();

        return view('addStudent', compact('degrees'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'contactno' => $request->input('contactno', $request->input('contact_no')),
        ]);

        $validated = $request->validate([
            'fname' => 'required|string|min:2|max:255',
            'lname' => 'required|string|min:2|max:255',
            'contactno' => 'required|string|min:11|max:11',
            'degree_id' => 'required|exists:degrees,id',
            'username' => 'required|string|min:3|max:255|unique:user_accounts,username',
            'email' => 'required|email|max:255|unique:user_accounts,email',
            'password' => 'required|string|min:8|max:255',
        ]);

        $student = DB::transaction(function () use ($validated): Student {
            $userAccount = UserAccounts::create([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => UserAccounts::ROLE_STUDENT,
                'is_active' => 1,
                'must_change_password' => true,
            ]);

            return Student::create([
                'fname' => $validated['fname'],
                'lname' => $validated['lname'],
                'contactno' => $validated['contactno'],
                'degree_id' => $validated['degree_id'],
                'user_account_id' => $userAccount->id,
            ]);
        });

        Log::info('New student added successfully.');

        if ($request->is('students') || $request->ajax() || $request->expectsJson()) {
            $student->load(['degree', 'userAccount']);

            return response()->json([
                'success' => true,
                'student' => $this->studentPayload($student),
                'redirect_url' => url('/manageStudents'),
            ]);
        }

        return redirect()->route('studentss.index')->with('success', 'Student added successfully.');
    }

    public function show(string $id)
    {
        $student = Student::with(['degree', 'userAccount'])->findOrFail($id);

        return view('studentDetails', compact('student'));
    }

    public function edit(string $id)
    {
        $student = Student::with('userAccount')->findOrFail($id);
        $degrees = Degree::orderBy('id')->get();

        return view('editStudent', compact('student', 'degrees'));
    }

    public function update(Request $request, string $id)
    {
        $student = Student::with('userAccount')->findOrFail($id);

        $request->merge([
            'contactno' => $request->input('contactno', $request->input('contact_no')),
            'username' => $request->input('username', $student->userAccount?->username),
        ]);

        $validated = $request->validate([
            'fname' => 'required|string|min:2|max:255',
            'lname' => 'required|string|min:2|max:255',
            'contactno' => 'required|string|min:11|max:11',
            'degree_id' => 'required|exists:degrees,id',
            'username' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('user_accounts', 'username')->ignore($student->user_account_id),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('user_accounts', 'email')->ignore($student->user_account_id),
            ],
            'password' => [
                $student->userAccount ? 'nullable' : 'required',
                'string',
                'min:8',
                'max:255',
            ],
        ]);

        DB::transaction(function () use ($student, $validated): void {
            $userAccountData = [
                'username' => $validated['username'],
                'email' => $validated['email'],
                'role' => UserAccounts::ROLE_STUDENT,
                'is_active' => 1,
            ];

            if (! empty($validated['password'])) {
                $userAccountData['password'] = Hash::make($validated['password']);
                $userAccountData['must_change_password'] = true;
            }

            if ($student->userAccount) {
                $student->userAccount->update($userAccountData);
            } else {
                $student->userAccount()->associate(UserAccounts::create($userAccountData));
            }

            $student->update([
                'fname' => $validated['fname'],
                'lname' => $validated['lname'],
                'contactno' => $validated['contactno'],
                'degree_id' => $validated['degree_id'],
                'user_account_id' => $student->user_account_id,
            ]);
        });

        Log::info('Student updated successfully.');

        if ($request->is('students/*') || $request->ajax() || $request->expectsJson()) {
            $student->load(['degree', 'userAccount']);

            return response()->json([
                'success' => true,
                'student' => $this->studentPayload($student),
                'redirect_url' => url('/manageStudents'),
            ]);
        }

        return redirect()->route('studentss.show', $student->id)->with('success', 'Student updated successfully.');
    }

    public function destroy(Request $request, string $id)
    {
        $student = Student::with('userAccount')->findOrFail($id);
        $studentName = $student->fname.' '.$student->lname;

        DB::transaction(function () use ($student): void {
            $student->delete();
            $student->userAccount?->delete();
        });

        Log::info('Student deleted successfully.', [
            'student_id' => $id,
            'student_name' => $studentName,
        ]);

        if ($request->is('students/*') || $request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
            ]);
        }

        return redirect()->route('studentss.index')->with('success', $studentName.' deleted successfully.');
    }

    private function studentPayload(Student $student): array
    {
        return [
            'id' => $student->id,
            'name' => trim($student->fname.' '.$student->lname),
            'fname' => $student->fname,
            'lname' => $student->lname,
            'full_name' => trim($student->fname.' '.$student->lname),
            'list_name' => trim($student->lname.', '.$student->fname),
            'contactno' => $student->contactno,
            'degree_id' => $student->degree_id,
            'degree_name' => $student->degree?->name,
            'user_account_id' => $student->user_account_id,
            'username' => $student->userAccount?->username,
            'email' => $student->userAccount?->email,
            'show_url' => route('studentss.show', $student),
        ];
    }
}
