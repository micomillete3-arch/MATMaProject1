@extends('layout.format')

@section('title', 'Add Teacher')
@section('hide_hero', '1')

@section('content')
    <style>
        .teacher-table-wrapper {
            overflow-x: auto;
        }

        .teacher-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
        }

        .teacher-table caption {
            caption-side: top;
            font-size: 1.5rem;
            margin-bottom: 12px;
            font-weight: 800;
            color: #2c3e50;
        }

        .teacher-table th,
        .teacher-table td {
            border: 1px solid #ddd;
            padding: 12px 15px;
            text-align: left;
        }

        .teacher-table th {
            background-color: #2c3e50;
            color: #ffffff;
            text-transform: uppercase;
        }

        .teacher-table tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        .teacher-table tbody tr:nth-child(even) {
            background-color: #eaf2fb;
        }

        .teacher-table tbody tr:hover {
            background-color: #d1e7ff;
        }

        .teacher-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .teacher-action-btn {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 5px;
            color: #ffffff;
            text-decoration: none;
            font-size: 14px;
        }

        .teacher-view-btn {
            background-color: #198754;
        }

        .teacher-view-btn:hover {
            background-color: #157347;
        }

        .teacher-edit-btn {
            background-color: #fd7e14;
        }

        .teacher-edit-btn:hover {
            background-color: #dc6a0c;
        }

        .teacher-delete-form {
            margin: 0;
        }

        .teacher-delete-btn {
            border: none;
            cursor: pointer;
            background-color: #dc3545;
        }

        .teacher-delete-btn:hover {
            background-color: #bb2d3b;
        }
    </style>

    <div class="content-grid" style="max-width: 980px; margin: 0 auto;">
        <section class="panel-card">
            <p class="section-kicker">Teacher Account</p>

            @if (session('status'))
                <div class="notice success">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="notice error">
                    {{ $errors->first() }}
                </div>
            @endif

            <div id="teacher-create-panel">
                <input type="hidden" id="fname" value="">
                <input type="hidden" id="lname" value="">
                <input type="hidden" id="password_confirmation" value="">

                <div class="content-grid">
                    <div class="two-column-grid">
                        <div class="definition-item">
                            <label for="username" style="display:block; margin-bottom:10px; font-size:0.74rem; letter-spacing:0.18em; text-transform:uppercase; font-weight:800; color:var(--accent);">Username</label>
                            <input
                                id="username"
                                name="username"
                                type="text"
                                value="{{ old('username') }}"
                                style="width:100%; border:1px solid var(--line); border-radius:16px; padding:14px 16px; font:inherit;"
                                required
                            >
                        </div>

                        <div class="definition-item">
                            <label for="email" style="display:block; margin-bottom:10px; font-size:0.74rem; letter-spacing:0.18em; text-transform:uppercase; font-weight:800; color:var(--accent);">Email</label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                style="width:100%; border:1px solid var(--line); border-radius:16px; padding:14px 16px; font:inherit;"
                                required
                            >
                        </div>
                    </div>

                    <div class="definition-item">
                        <label for="password" style="display:block; margin-bottom:10px; font-size:0.74rem; letter-spacing:0.18em; text-transform:uppercase; font-weight:800; color:var(--accent);">Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            style="width:100%; border:1px solid var(--line); border-radius:16px; padding:14px 16px; font:inherit;"
                            minlength="8"
                            required
                        >
                    </div>

                    <div class="button-row">
                        <button type="button" id="saveTeacher" class="button-link" style="border:0; cursor:pointer;">Save Teacher</button>
                        <a href="{{ route('admin.dashboard') }}" class="button-link secondary">Back to Admin Dashboard</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="panel-card">
            <div id="teachers_list" class="teacher-table-wrapper">
                @include('partials.teachers_list', ['teachers' => $teachers])
            </div>
        </section>
    </div>
@endsection

@section('footer', 'Only administrators can create teacher accounts.')

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
@endpush
