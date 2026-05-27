@extends('layout.format')

@section('title', 'Student Courses')
@section('header', 'Student Courses')

@section('content')
    <style>
        .student-course-list {
            display: grid;
            gap: 8px;
            max-width: 560px;
            margin: 0 auto;
            font-family: Arial, sans-serif;
            font-size: 16px;
        }

        .student-course-row {
            display: grid;
            grid-template-columns: minmax(180px, 1fr) minmax(90px, auto);
            gap: 28px;
            align-items: center;
            padding: 10px 12px;
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(14, 61, 62, 0.12);
            border-radius: 8px;
        }

        .student-course-name {
            font-weight: 700;
            color: #183536;
        }

        .student-course-code {
            color: #0f4b4c;
            font-weight: 700;
            text-align: left;
        }

        .student-course-empty {
            text-align: center;
            color: #607775;
            font-weight: 700;
        }

        @media (max-width: 520px) {
            .student-course-row {
                grid-template-columns: 1fr;
                gap: 4px;
            }
        }
    </style>

    <div class="student-course-list">
        @forelse ($courseStudents as $courseStudent)
            <div class="student-course-row">
                <span class="student-course-name">{{ $courseStudent->student_name }}</span>
                <span class="student-course-code">{{ $courseStudent->course_name }}</span>
            </div>
        @empty
            <div class="student-course-empty">No courses found.</div>
        @endforelse
    </div>
@endsection
