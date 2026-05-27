<?php

namespace App\Http\Controllers;

use App\Models\UserAccounts;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function login(Request $request): RedirectResponse
    {
        $userName = $request->input('username');
        $passwordInput = $request->input('password');

        if (! $request->filled('username') && ! $request->filled('password')) {
            return redirect()->route('student.login');
        }

        if (! $userName || ! $passwordInput) {
            return redirect()
                ->route('student.login')
                ->with('message', 'Please enter your username and password.')
                ->withInput($request->only('username'));
        }

        $user = $this->findActiveUserByUsername($userName);

        if (! $user || ! Hash::check($passwordInput, $user->password)) {
            return redirect()
                ->route('student.login')
                ->with('message', 'Wrong credentials. Please try again.')
                ->withInput($request->only('username'));
        }

        Auth::login($user);
        $request->session()->regenerate();
        $request->session()->put('loggedId', $user->id);
        $request->session()->put('loggedRole', $user->role);
        $request->session()->put('loggedUser', $user->username);
        $request->session()->put('dashboardRoute', $user->dashboardRoute());

        if ($user->must_change_password) {
            $request->session()->put('password_change_user_id', $user->id);
            $request->session()->forget(['loggedId', 'loggedRole', 'loggedUser', 'dashboardRoute']);
            Auth::logout();

            return redirect()
                ->route('student.password.change')
                ->with('status', 'Please change your password before logging in again.');
        }

        return redirect()->route($user->dashboardRoute());
    }

    public function teacherDashboard(): View
    {
        /** @var UserAccounts $user */
        $user = Auth::user();

        return view('teacherDashboard', compact('user'));
    }

    public function findActiveUserByUsername(string $username): ?UserAccounts
    {
        return UserAccounts::where('username', $username)
            ->where('is_active', 1)
            ->first();
    }

    public function findUserById(int $id): UserAccounts
    {
        return UserAccounts::findOrFail($id);
    }
}
