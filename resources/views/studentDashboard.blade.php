@extends('layout.format')

@section('title', 'Student Dashboard')

@section('hide_hero', '1')

@section('content')
    @if (session('status'))
        <div class="notice success">{{ session('status') }}</div>
    @endif

    <section class="panel-card" style="max-width: 640px; margin: 0 auto;">
        <p class="section-kicker">Student Information</p>

        <dl class="definition-list">
            <div class="definition-item">
                <dt>Name</dt>
                <dd>{{ $student->fname }} {{ $student->lname }}</dd>
            </div>

            <div class="definition-item">
                <dt>Username</dt>
                <dd>{{ $user->username }}</dd>
            </div>

            <div class="definition-item">
                <dt>Email</dt>
                <dd>{{ $user->email }}</dd>
            </div>
        </dl>
    </section>
@endsection

@section('footer', 'Simple student dashboard view')
