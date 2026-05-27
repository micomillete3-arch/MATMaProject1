<?php

namespace App\Http\Controllers;

use App\Models\UserAccounts;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class StudentAuthController extends Controller
{
    public function __construct(private UserController $users)
    {
    }

    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route(Auth::user()->dashboardRoute());
        }

        return view('studentLogin');
    }

    public function login(Request $request): RedirectResponse
    {
        return $this->users->login($request);
    }

    public function showChangePasswordForm(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('password_change_user_id')) {
            return redirect()->route('student.login');
        }

        return view('studentChangePassword');
    }

    public function changePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $userId = $request->session()->get('password_change_user_id');

        if (! $userId) {
            return redirect()->route('student.login');
        }

        $user = $this->users->findUserById((int) $userId);

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'must_change_password' => false,
        ]);

        $request->session()->forget('password_change_user_id');

        return redirect()
            ->route('student.login')
            ->with('status', 'Password changed successfully. Please log in with your new password.');
    }

    public function dashboard(): View
    {
        /** @var UserAccounts $user */
        $user = Auth::user();
        $student = $user->load(['student.degree'])->student;

        abort_unless($student, 404);

        return view('studentDashboard', compact('student', 'user'));
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget([
            'loggedId',
            'loggedRole',
            'loggedUser',
            'dashboardRoute',
            'password_change_user_id',
        ]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('student.login');
    }
}
