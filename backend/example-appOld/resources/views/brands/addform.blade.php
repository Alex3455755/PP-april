resources > views > personal > @addform.blade.php
@extends('layouts.base')
@section('title', 'Добавление объявления')
@section('main')
<form method="post" action="{{ route('brand.store') }}">
    @csrf
    <div class="form-group">
        <label for="txtTitle">Название</label>
        <input type="text" name="name" id="txtTitle" class="form-control">
    </div>
    <div class="form-group">
        <label for="txtContent">Страна</label>
        <input name="country" id="txtContent" class="form-control"/>
    </div>
    <div class="form-group">
        <label for="txtPrice">Сайт</label>
        <input type="text" name="web_site" id="txtPrice" class="form-control">
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary">Добавить</button>
    </div>
</form>
@endsection('main')