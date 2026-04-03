@extends('layouts.base')
@section('title', 'Добавление объявления')
@section('main')
<form method="post" action="{{ route('clothes.store') }}">
    @csrf
    <div class="form-group">
        <label for="txtTitle">Название</label>
        <input type="text" name="title" id="txtTitle" class="form-control">
    </div>
    <div class="form-group">
        <label for="txtContent">Размер</label>
        <input name="size" id="txtContent" class="form-control"/>
    </div>
    <div class="form-group">
        <label for="txtPrice">Цена</label>
        <input type="number" name="price" id="txtPrice" class="form-control">
    </div>
        <div class="form-group">
        <label for="txtColor">Цвет</label>
        <input type="text" name="color" id="txtColor" class="form-control">
    </div>
    <div class="form-group">
        <label for="brandSelect">Бренд</label>
        <select name="brand_id" id="brandSelect" class="form-control">
            <option value="">Выберите бренд</option>
            @foreach($brands as $brand)
                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary">Добавить</button>
    </div>
</form>
@endsection('main')