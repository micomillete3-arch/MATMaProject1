@extends('layout.auth')

@section('title', 'Change Password')

@section('card_eyebrow', 'Password Update')

@section('card_title', 'Set your new password')

@section('card_copy', 'Use your current password once, then replace it with a stronger one that is easier for you to remember and harder for others to guess.')

@section('form')
    <form action="{{ route('student.password.update') }}" method="POST">
        @csrf

        <div class="form-grid">
            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input
                    type="password"
                    id="current_password"
                    name="current_password"
                    autocomplete="current-password"
                    placeholder="Enter your current password"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">New Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    autocomplete="new-password"
                    placeholder="Create a new password"
                    minlength="8"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm New Password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    autocomplete="new-password"
                    placeholder="Re-enter your new password"
                    minlength="8"
                    required
                >
            </div>

            <button type="submit" class="submit-button">Save New Password</button>
        </div>
    </form>
@endsection

@section('helper_copy', 'After saving, use your updated password the next time you sign in to the portal.')
