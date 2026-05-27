@extends('layout.format')

@section('title', 'Students AJAX CRUD')
@section('hide_hero', '1')

@section('content')
<style>
    .ajax-crud-wrapper {
        display: grid;
        gap: 18px;
        font-family: Arial, sans-serif;
    }

    .ajax-crud-wrapper h2,
    .ajax-crud-wrapper h3 {
        margin: 0;
        color: #2c3e50;
    }

    .student-form {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
        padding: 18px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.08);
    }

    .form-group {
        display: grid;
        gap: 6px;
    }

    .form-group label {
        font-weight: bold;
        color: #333;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
    }

    .form-actions {
        grid-column: 1 / -1;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn {
        display: inline-block;
        padding: 8px 12px;
        border: 0;
        border-radius: 5px;
        color: white;
        text-decoration: none;
        font-size: 14px;
        cursor: pointer;
    }

    .btn-primary {
        background: #0d6efd;
    }

    .btn-warning {
        background: #fd7e14;
    }

    .btn-danger {
        background: #dc3545;
    }

    .btn-success {
        background: #198754;
    }

    .btn-secondary {
        background: #6c757d;
    }

    #message {
        min-height: 22px;
        font-weight: bold;
        color: #198754;
    }

    .table-shell {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 12px 15px;
        text-align: left;
    }

    th {
        background: #2c3e50;
        color: white;
        text-transform: uppercase;
    }

    tbody tr:nth-child(odd) {
        background: #f9f9f9;
    }

    tbody tr:nth-child(even) {
        background: #eaf2fb;
    }

    @media (max-width: 720px) {
        .student-form {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="ajax-crud-wrapper">
    <div id="message"></div>

    <div id="student-create-panel" class="student-form">
        <div class="form-group">
            <label for="fname">First Name</label>
            <input type="text" id="fname" placeholder="Enter first name">
        </div>

        <div class="form-group">
            <label for="lname">Last Name</label>
            <input type="text" id="lname" placeholder="Enter last name">
        </div>

        <div class="form-group">
            <label for="contact_no">Contact Number</label>
            <input type="text" id="contact_no" placeholder="Enter contact number" maxlength="11">
        </div>

        <div class="form-group">
            <label for="degree_id">Degree</label>
            <select id="degree_id">
                <option value="">Select Degree</option>
                @foreach ($degrees as $degree)
                    <option value="{{ $degree->id }}">{{ $degree->id }} - {{ $degree->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" placeholder="Enter username">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" placeholder="Enter email">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" placeholder="Enter password">
        </div>

        <div class="form-actions">
            <button type="button" id="saveStudent" class="btn btn-primary">Save Student</button>
        </div>
    </div>

    <div id="students_list" class="table-shell"></div>
</div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
@endpush
