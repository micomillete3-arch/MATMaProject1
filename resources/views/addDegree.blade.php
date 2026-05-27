@extends('layout.format')

@section('title', 'Degrees')
@section('hide_hero', '1')

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

    .alert-success {
        background-color: #d1e7dd;
        color: #0f5132;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #842029;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    .list-container {
        width: min(900px, calc(100% - 40px));
        margin: 0 auto 30px;
        padding: 25px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
    }

    .list-container h3 {
        margin-top: 0;
        color: #2c3e50;
        text-align: center;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 10px 12px;
        text-align: left;
    }

    th {
        background-color: #2c3e50;
        color: white;
    }

    .actions {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
    }

    .action-link {
        display: inline-block;
        padding: 8px 12px;
        border-radius: 5px;
        color: white;
        text-decoration: none;
        font-size: 14px;
    }

    .view-btn {
        background-color: #198754;
    }

    .view-btn:hover {
        background-color: #157347;
    }

    .edit-btn {
        background-color: #fd7e14;
    }

    .edit-btn:hover {
        background-color: #dc6a0c;
    }

    .delete-form {
        margin: 0;
    }

    .delete-btn {
        border: none;
        cursor: pointer;
        background-color: #dc3545;
        color: white;
        padding: 8px 12px;
        border-radius: 5px;
        font-size: 14px;
    }

    .delete-btn:hover {
        background-color: #bb2d3b;
    }

    .in-use-text {
        color: #6c757d;
        font-size: 14px;
    }
</style>

<div class="form-container">
    <h2>Add New Degree</h2>

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert-error">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="error-box">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div id="degree-create-panel">
        <div class="form-group">
            <label for="degree_name">Degree Name</label>
            <input type="text" name="name" id="degree_name" value="{{ old('name') }}">
        </div>

        <button type="button" id="saveDegree" class="btn-submit">Save Degree</button>
        <a href="{{ route('studentss.index') }}" class="btn-back">Back</a>
    </div>
</div>

<div class="list-container">
    <h3>Existing Degrees</h3>

    <div id="degrees_list">
        @include('partials.degrees_list', ['degrees' => $degrees])
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
@endpush
