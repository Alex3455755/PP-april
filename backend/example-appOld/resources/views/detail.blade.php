@extends('layouts.base')

@section('title', 'Объявление')

@section('main')
    <div class="container">
        <h2> {{ $sale->title }} </h2>
        <p> {{ $sale->content }} </p>
        <p> {{ $sale->price }} </p>
        <p> {{ $sale->user->name }}</p>
        <p>
            <a href='{{ route("sale.index") }}'>  перечень объявлений</a>
        </p>
    </div>
@endsection('main')