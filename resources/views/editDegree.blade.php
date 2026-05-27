@extends('layout.format')

@section('title', 'Edit Degree')
@section('header', 'Edit Degree')

@section('content')
<style>
    .form-container {
        width: min(500px, calc(100% - 40px));
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

    .form-group input {
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

    .error-box {
        background-color: #f8d7da;
        color: #842029;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    .meta-text {
        color: #6c757d;
        margin-bottom: 15px;
        text-align: center;
    }
</style>

<div class="form-container">
    <h2>Edit Degree</h2>

    <p class="meta-text">Students using this degree: {{ $degree->students_count }}</p>

    @if ($errors->any())
        <div class="error-box">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div id="degree-edit-panel">
        <input type="hidden" id="id" value="{{ $degree->id }}">

        <div class="form-group">
            <label for="degree_name">Degree Name</label>
            <input type="text" name="name" id="degree_name" value="{{ old('name', $degree->name) }}">
        </div>

        <button type="button" id="updateDegreeBtn" class="btn-submit">Update Degree</button>
        <a href="{{ route('degrees.show', $degree->id) }}" class="btn-back">Back</a>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
@endpush
