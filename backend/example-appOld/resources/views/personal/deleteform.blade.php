@extends('layouts.base')

@section('title', 'Удаление объявления')

@section('main')
<h2>{{ $sale->title }}</h2>
<p>{{ $sale->content }}</p>
<p>{{ $sale->price }}</p>
<p>Aвтор: {{ $sale->user->name }}</p>

<form action='{{ route("personal.destroy", ["sale" => $sale->id]) }}' method="POST">
@csrf
@method('DELETE')
<button type="submit" class="btn btn-danger">Удалить</button>
</form>
<p><a href='{{ route("personal.index") }}'>В личный кабинет</a></p>
@endsection('main')