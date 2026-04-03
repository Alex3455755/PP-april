@extends('layouts.base')
@section('title', 'Добавление объявления')
@section('main')
<form method="post" action="{{ route('personal.store') }}">
    @csrf
    <div class="form-group">
        <label for="txtTitle">Товар</label>
        <input type="text" name="title" id="txtTitle" class="form-control">
    </div>
    <div class="form-group">
        <label for="txtContent">Описание</label>
        <textarea name="content" id="txtContent" class="form-control" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label for="txtPrice">Цена</label>
        <input type="text" name="price" id="txtPrice" class="form-control">
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary">Добавить</button>
    </div>
</form>
@endsection('main')