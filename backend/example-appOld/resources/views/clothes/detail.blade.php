@extends('layouts.base')

@section('title', 'Удаление одежды')

@section('main')

    <div class="container">
        <h2> {{ $clouthe-> title }} </h2>
        <p> {{ $clouthe->size }} </p>
        <p> {{ $clouthe->price }} </p>
        <p> {{ $clouthe->brand->name }}</p>
        <p> {{ $clouthe->color }} </p>
        <p>
            <a href="{{ url('/clouthe') }}">  перечень одежды</a>
        </p>
    </div>
@endsection('main')