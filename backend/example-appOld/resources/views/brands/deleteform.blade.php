@extends('layouts.base')

@section('title', 'Удаление объявления')

@section('main')
<h2>{{ $brand->name }}</h2>
<p>{{ $brand->country }}</p>
<p>{{ $brand->web_site }}</p>

<form action='{{ route("brand.destroy", ["brand" => $brand->id]) }}' method="POST">
@csrf
@method('DELETE')
<button type="submit" class="btn btn-danger">Удалить</button>
</form>
<p><a href='{{ route("brand.list") }}'>В личный кабинет</a></p>
@endsection('main')