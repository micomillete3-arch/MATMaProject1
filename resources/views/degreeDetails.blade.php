@extends('layout.format')

@section('title', 'Degree Details')
@section('header', 'Degree Details')

@section('content')
<style>
    .details-card {
        width: min(650px, calc(100% - 40px));
        margin: 30px auto;
        padding: 25px;
        background-color: #ffffff;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
    }

    .details-card h2 {
        margin-top: 0;
        color: #2c3e50;
        text-align: center;
    }

    .alert-success {
        margin-bottom: 20px;
        padding: 12px 15px;
        background-color: #d1e7dd;
        color: #0f5132;
        border: 1px solid #badbcc;
        border-radius: 5px;
    }

    .detail-row {
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }

    .detail-label {
        display: block;
        font-weight: bold;
        color: #2c3e50;
        margin-bottom: 4px;
    }

    .action-row {
        display: flex;
        gap: 12px;
        margin-top: 25px;
        flex-wrap: wrap;
    }

    .action-btn {
        display: inline-block;
        padding: 10px 18px;
        border-radius: 5px;
        text-decoration: none;
        color: white;
    }

    .back-btn {
        background-color: #6c757d;
    }

    .back-btn:hover {
        background-color: #5c636a;
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
        padding: 10px 18px;
        border-radius: 5px;
        font-size: 14px;
    }

    .delete-btn:hover {
        background-color: #bb2d3b;
    }

    .in-use-text {
        color: #6c757d;
        font-size: 14px;
        align-self: center;
    }
</style>

<div class="details-card">
    <h2>{{ $degree->name }}</h2>

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="detail-row">
        <span class="detail-label">ID</span>
        <span>{{ $degree->id }}</span>
    </div>

    <div class="detail-row">
        <span class="detail-label">Degree Name</span>
        <span>{{ $degree->name }}</span>
    </div>

    <div class="detail-row">
        <span class="detail-label">Students Using It</span>
        <span>{{ $degree->students_count }}</span>
    </div>

    <div class="action-row">
        <a href="{{ route('degrees.index') }}" class="action-btn back-btn">Back to Degrees</a>
        <a href="{{ route('degrees.edit', $degree->id) }}" class="action-btn edit-btn">Edit Degree</a>

        @if ($degree->students_count == 0)
            <button type="button" class="delete-btn" onclick="deleteDegree({{ $degree->id }})">Delete Degree</button>
        @else
            <span class="in-use-text">This degree is currently assigned to students.</span>
        @endif
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
@endpush
