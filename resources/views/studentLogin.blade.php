@extends('layout.auth')

@section('title', 'Student Login')

@section('card_eyebrow', 'Portal Login')

@section('card_title', 'Welcome back')


@section('form')
    <form action="{{ route('student.login.submit') }}" method="POST">
        @csrf

        <div class="form-grid">
            <div class="form-group">
                <label for="username">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username') }}"
                    autocomplete="username"
                    placeholder="Enter your username"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    autocomplete="current-password"
                    placeholder="Enter your password"
                    required
                >
            </div>  

            <button type="submit" class="submit-button">Login</button>
        </div>
    </form>
@endsection
