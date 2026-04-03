@extends('layouts.base')

@section('title', 'Мои объявления')

@section('main')
    <p>Добро пожаловать, {{ Auth::user()->name }}</p>
    <p><a href="{{ route('personal.add') }}">Добавить объявление</a></p>
    @if (count($sales) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Тема</th>
                    <th>Цена, руб</th>
                    <th colspan="2">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $sale)
                    <tr>
                        <td><h3>{{ $sale->title }}</h3></td>
                        <td>{{ $sale->price }}</td>
                        <td>
                            <a href='{{ route("personal.edit",["sale" => $sale->id]) }}'>Редактировать</a>
                        </td>
                        <td>
                            <a href='{{ route("personal.delete",["sale" => $sale->id]) }}'>Удалить</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection