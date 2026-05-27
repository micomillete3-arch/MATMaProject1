@extends('layout.format')

@section('title', 'Dashboard')

@section('hide_hero', '1')

@section('content')
    <section class="panel-card" style="max-width: 640px; margin: 0 auto;">
        <p class="section-kicker">Account Information</p>

        <dl class="definition-list">
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

@section('footer', 'Simple dashboard view')
