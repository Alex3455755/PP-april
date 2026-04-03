@extends('layouts.base')

@section('title', 'Wavenewue объявления')

@section('main')
<form method="post" action="{{ route('personal.update', ['sale' => $sale->id]) }}">
    @csrf
    @method('PATCH')
    <div class="form-group">
        <label for="txtTitle">Товар</label>
        <input type="text" name="title" id="txtTitle" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $sale->title) }}">
        @error('title')
        <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="txtContent">Описание</label>
        <textarea name="content" id="txtContent" class="form-control" rows="3">{{ old('content', $sale->content) }}</textarea>
        @error('content')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="txtPrice">Цена</label>
        <input step="0.01" min="0.01" type="number" name="price" id="txtPrice" class="form-control" value="{{ old('price', $sale->price) }}">
        @error('price')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</form>
@endsection