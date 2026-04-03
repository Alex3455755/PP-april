
@extends('layouts.base')

@section('title', 'Авторизация')

@section('main')
    <div class="container">
        <p><a href="{{ route('brand.add') }}">Добавить бренд</a></p>
        @if (count($brands) > 0)
        <table class = "table table-striped">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Страна</th>
                    <th>Сайт</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            <tbody>
                @foreach ($brands as $elem)
                                <tr>
                    <td><h3>{{ $elem-> name }}</h3></td>
                    <td>{{$elem -> country}}</td>
                    <td>{{$elem-> web_site}}</td>
                    <td>
                        <a href='{{ url("/brand/{$elem->id}") }}'>Подробнее</a>
                    </td>
                    <td>
                            <a href='{{ route("brand.edit",["brand" => $elem->id]) }}'>Редактировать</a>
                        </td>
                        <td>
                            <a href='{{ route("brand.delete",["brand" => $elem->id]) }}'>Удалить</a>
                        </td>
                </tr>
                @endforeach
            </tbody>
            </tbody>
        </table>
        @endif
        <a href="http://localhost/example-app/public/clouthe">Одежда</a>
@endsection