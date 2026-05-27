@extends('layout.format')

@section('title', 'Admin Dashboard')
@section('hide_hero', '1')

@section('content')
    <div class="content-grid">
        <div class="two-column-grid">
            <section class="panel-card">
                <p class="section-kicker">Recent Teachers</p>

                <div class="definition-list">
                    @forelse ($teachers as $teacher)
                        <div class="definition-item">
                            <dt>{{ $teacher->username }}</dt>
                            <dd>{{ $teacher->email }}</dd>
                        </div>
                    @empty
                        <div class="definition-item">
                            <dt>No teachers yet</dt>
                            <dd>Create a teacher account from the admin tools above.</dd>
                        </div>
                    @endforelse
                </div>
            </section>

            <section class="panel-card">
                <p class="section-kicker">Latest Students</p>

                <div class="definition-list">
                    @forelse ($latestStudents as $student)
                        <div class="definition-item">
                            <dt>{{ $student->fname }} {{ $student->lname }}</dt>
                            <dd>{{ optional($student->degree)->name ?? 'No degree assigned' }} | {{ optional($student->userAccount)->username ?? 'No username' }}</dd>
                        </div>
                    @empty
                        <div class="definition-item">
                            <dt>No students yet</dt>
                            <dd>Add a student account to populate this dashboard.</dd>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
@endsection

@section('footer', 'Admin access includes student and teacher account creation.')
