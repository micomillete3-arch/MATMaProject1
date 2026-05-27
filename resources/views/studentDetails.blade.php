@extends('layout.format')

@section('title', 'Student Details')
@section('header', 'Student Details')

@section('content')
<style>
    .details-card {
        max-width: 650px;
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
    }

    .delete-btn:hover {
        background-color: #bb2d3b;
    }
</style>

<div class="details-card">
    <h2>{{ $student->fname }} {{ $student->lname }}</h2>

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="detail-row">
        <span class="detail-label">First Name</span>
        <span>{{ $student->fname }}</span>
    </div>

    <div class="detail-row">
        <span class="detail-label">Last Name</span>
        <span>{{ $student->lname }}</span>
    </div>

    <div class="detail-row">
        <span class="detail-label">User Account Email</span>
        <span>{{ optional($student->userAccount)->email ?? 'Not set' }}</span>
    </div>

    <div class="detail-row">
        <span class="detail-label">Username</span>
        <span>{{ optional($student->userAccount)->username ?? 'Not set' }}</span>
    </div>

    <div class="detail-row">
        <span class="detail-label">Degree</span>
        <span>{{ optional($student->degree)->name ?? 'Not set' }}</span>
    </div>

    <div class="detail-row">
        <span class="detail-label">Contact Number</span>
        <span>{{ $student->contactno }}</span>
    </div>

    <div class="action-row">
        <a href="{{ route('studentss.index') }}" class="action-btn back-btn">Back to List</a>
        <a href="{{ route('studentss.edit', $student->id) }}" class="action-btn edit-btn">Edit Student</a>
        <button type="button" class="action-btn delete-btn" onclick="deleteStudent({{ $student->id }})">Delete Student</button>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
@endpush
