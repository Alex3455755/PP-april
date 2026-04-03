@extends('layouts.base')

@section('title', 'Регистрация')

@section('main')
<form class="register-form auth-signup-form" method="post" action="{{ route('auth.register') }}">
    @csrf
    <div class="name mb-3">
        <label class="sr-only" for="signup-name">Ваше имя</label>
        <input id="signup-name" name="name" type="text" class="form-control signup-name" placeholder="Ваше имя" required>
    </div>
    <div class="email mb-3">
        <label class="sr-only" for="signup-email">Ваш e-mail</label>
        <input id="signup-email" name="email" type="email" class="form-control signup-email" placeholder="Ваш e-mail" required>
    </div>
    <div class="password mb-3">
        <label class="sr-only" for="signup-password">Ваш пароль</label>
        <input id="signup-password" name="password" type="password" class="form-control signup-password" placeholder="Ваш пароль" required>
    </div>
    <div class="password_confirmation mb-3">
        <label class="sr-only" for="signup-password_confirmation">Ваш пароль</label>
        <input id="signup-password_confirmation" name="password_confirmation" type="password" class="form-control signup-password_confirmation" placeholder="Подтвердите пароль" required>
    </div>
    <div class="text-center">
        <button type="submit" class="btn app-btn-primary btn-block theme-btn mx-auto">Регистрация</button>
    </div>
</form>
@endsection