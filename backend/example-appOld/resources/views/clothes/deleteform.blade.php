@extends('layouts.base')

@section('title', 'Удаление объявления')

@section('main')
<h2>{{ $clouthe->title }}</h2>
<p>Размер: {{ $clouthe->size }}</p>
<p>Цена: {{ $clouthe->price }}</p>
<p>Цвет: {{ $clouthe->color }}</p>
<p>Бренд: {{ $clouthe->brand->name }}</p>

<form action='{{ route("clothes.destroy", ["clouthe" => $clouthe->id]) }}' method="POST">
@csrf
@method('DELETE')
<button type="submit" class="btn btn-danger">Удалить</button>
</form>
<p><a href='{{ route("clothes.list") }}'>Назад к списку</a></p>
@endsection('main')