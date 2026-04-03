@extends('layouts.base')

@section('title', 'Редактирование одежды')

@section('main')
<form method="post" action="{{ route('clothes.update', ['clouthe' => $clouthe->id]) }}">
    @csrf
    @method('PATCH')
    <div class="form-group">
        <label for="txtTitle">Название</label>
        <input type="text" name="title" id="txtTitle" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $clouthe->title) }}">
        @error('title')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="txtSize">Размер</label>
        <input type="text" name="size" id="txtSize" class="form-control @error('size') is-invalid @enderror" value="{{ old('size', $clouthe->size) }}">
        @error('size')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="txtPrice">Цена</label>
        <input type="number" name="price" id="txtPrice" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $clouthe->price) }}">
        @error('price')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="txtColor">Цвет</label>
        <input type="text" name="color" id="txtColor" class="form-control @error('color') is-invalid @enderror" value="{{ old('color', $clouthe->color) }}">
        @error('color')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="brandSelect">Бренд</label>
        <select name="brand_id" id="brandSelect" class="form-control @error('brand_id') is-invalid @enderror">
            <option value="">Выберите бренд</option>
            @foreach($brands as $brandItem)
                <option value="{{ $brandItem->id }}" {{ old('brand_id', $clouthe->brand_id) == $brandItem->id ? 'selected' : '' }}>
                    {{ $brandItem->name }}
                </option>
            @endforeach
        </select>
        @error('brand_id')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</form>
@endsection