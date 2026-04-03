@extends('layouts.base')

@section('title', 'Wavenewue объявления')

@section('main')
<form method="post" action="{{ route('brand.update', ['brand' => $brand->id]) }}">
    @csrf
    @method('PATCH')
    <div class="form-group">
        <label for="txtTitle">Название</label>
        <input type="text" name="name" id="txtTitle" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $brand->name) }}">
        @error('title')
        <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="txtContent">Страна</label>
        <input name="country" id="txtContent" class="form-control" rows="3" value ="{{ old('content', $brand->country) }}" />
        @error('content')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="txtPrice"></label>
        <input type="text" name="web_site" id="txtPrice" class="form-control" value="{{ old('price', $brand->web_site) }}">
        @error('price')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</form>
@endsection