@extends('layout.format')

@section('title', 'Edit Student')
@section('header', 'Edit Student')

@section('content')
<style>
    .form-container {
        width: 500px;
        margin: 30px auto;
        padding: 25px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
    }

    .form-container h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #2c3e50;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
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

    .btn-submit {
        background-color: #fd7e14;
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-submit:hover {
        background-color: #dc6a0c;
    }

    .btn-back {
        background-color: #6c757d;
        color: white;
        text-decoration: none;
        padding: 10px 18px;
        border-radius: 5px;
        margin-left: 10px;
    }

    .btn-back:hover {
        background-color: #5c636a;
    }

    .btn-delete {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        margin-left: 10px;
    }

    .btn-delete:hover {
        background-color: #bb2d3b;
    }

    .delete-form {
        display: inline-block;
        margin: 0;
    }

    .error-box {
        background-color: #f8d7da;
        color: #842029;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
    }
</style>

<div class="form-container">
    <h2>Edit Student</h2>

    @if ($errors->any())
        <div class="error-box">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div id="student-edit-panel">
        <input type="hidden" id="id" value="{{ $student->id }}">

        <div class="form-group">
            <label for="f_name">First Name</label>
            <input type="text" name="fname" id="f_name" value="{{ old('fname', $student->fname) }}">
        </div>

        <div class="form-group">
            <label for="lname">Last Name</label>
            <input type="text" name="lname" id="lname" value="{{ old('lname', $student->lname) }}">
        </div>

        <div class="form-group">
            <label for="contact_no">Contact Number</label>
            <input type="text" name="contactno" id="contact_no" value="{{ old('contactno', $student->contactno) }}">
        </div>

        <div class="form-group">
            <label for="degree_id">Degree</label>
            <select name="degree_id" id="degree_id">
                <option value="">Select Degree</option>
                @foreach ($degrees as $degree)
                    <option value="{{ $degree->id }}" @selected(old('degree_id', $student->degree_id) == $degree->id)>
                        {{ $degree->id }} - {{ $degree->name }}
                    </option>
                @endforeach
            </select>
            <a href="{{ route('degrees.create') }}" style="display:inline-block; margin-top:8px; color:#0d6efd;">Add another degree</a>
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="{{ old('username', optional($student->userAccount)->username) }}">
        </div>

        <div class="form-group">
            <label for="email">User Account Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', optional($student->userAccount)->email) }}">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>

        <button type="button" id="updateStudentBtn" class="btn-submit">Update Student</button>
        <a href="{{ route('studentss.show', $student->id) }}" class="btn-back">Back</a>
    </div>

    
</div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
@endpush
