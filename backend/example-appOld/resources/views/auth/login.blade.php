@extends('layouts.base')

@section('title', 'Авторизация')

@section('main')
<form class="auth-form auth-signin-form" method="post" action="{{ route('auth.login') }}">
    @csrf
    <div class="email mb-3">
        <label class="sr-only" for="signin-email">Ваш e-mail</label>
        <input id="signin-email" name="email" type="email" class="form-control signin-email" placeholder="Ваш e-mail" required>
    </div>
    <div class="password mb-3">
        <label class="sr-only" for="signin-password">Ваш пароль</label>
        <input id="signin-password" name="password" type="password" class="form-control signin-password" placeholder="Ваш пароль" required>
    </div>

    <div class="text-center">
        <button type="submit" class="btn app-btn-primary btn-block theme-btn mx-auto">Войти</button>
    </div>
</form>
@endsection