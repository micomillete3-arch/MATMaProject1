@extends('layout.format')

@section('title', 'Add Student')
@section('header', 'Add Student')

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
        background-color: #0d6efd;
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-submit:hover {
        background-color: #0b5ed7;
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

    .error-box {
        background-color: #f8d7da;
        color: #842029;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
    }
</style>

<div class="form-container">
    <h2>Add New Student</h2>

    @if ($errors->any())
        <div class="error-box">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div id="student-create-panel">
        <div class="form-group">
            <label for="fname">First Name</label>
            <input type="text" name="fname" id="fname" value="{{ old('fname') }}">
        </div>

        <div class="form-group">
            <label for="lname">Last Name</label>
            <input type="text" name="lname" id="lname" value="{{ old('lname') }}">
        </div>

        <div class="form-group">
            <label for="contact_no">Contact Number</label>
            <input type="text" name="contactno" id="contact_no" value="{{ old('contactno') }}">

             <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}">
        </div>
        </div>

        <div class="form-group">
            <label for="degree_id">Degree</label>
            <select name="degree_id" id="degree_id">
                <option value="">Select Degree</option>
                @foreach ($degrees as $degree)
                    <option value="{{ $degree->id }}" @selected(old('degree_id') == $degree->id)>
                        {{ $degree->id }} - {{ $degree->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="{{ old('username') }}">
        </div>

       

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>

        <button type="button" id="saveStudent" class="btn-submit">Save Student</button>
        <a href="{{ route('studentss.index') }}" class="btn-back">Back</a>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
@endpush
