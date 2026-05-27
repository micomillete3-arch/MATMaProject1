@extends('layout.format')

@section('title', 'Teacher Dashboard')
@section('hide_hero', '1')

@section('content')
    <div class="content-grid">
        <section class="panel-card feature-card">
            <p class="section-kicker">Account Overview</p>
            <div class="definition-list">
                <div class="definition-item">
                    <dt>Username</dt>
                    <dd>{{ $user->username }}</dd>
                </div>

                <div class="definition-item">
                    <dt>Email</dt>
                    <dd>{{ $user->email }}</dd>
                </div>

                <div class="definition-item">
                    <dt>Role</dt>
                    <dd>{{ ucfirst($user->role) }}</dd>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('footer', 'Teacher access secured through role middleware and session login.')
