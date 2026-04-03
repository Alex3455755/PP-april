@extends('layouts.base')

@section('title', 'Одежда')

@section('main')
    <div class="container">
        <p><a href="{{ route('clothes.add') }}">Добавить Одежду</a></p>
        @if (count($clouthes) > 0)
        <table class = "table table-striped">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Размер</th>
                    <th>Цена, руб</th>
                    <th>Цвет</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clouthes as $elem)
                <tr>
                    <td><h3>{{ $elem->title }}</h3></td>
                    <td>{{ $elem->size }}</td>
                    <td>{{ $elem->price }}</td>
                    <td>{{ $elem->color }}</td>
                    <td>
                        <a href='{{ route("clothes.detail", ["clouthe" => $elem->id]) }}'>Подробнее</a>
                    </td>
                    <td>
                        <a href='{{ route("clothes.edit", ["clouthe" => $elem->id]) }}'>Редактировать</a>
</td>
<td>
                        <a href='{{ route("clothes.delete", ["clouthe" => $elem->id]) }}'>Удалить</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
        <a href="{{ route('brand.list') }}">Бренды</a>
    </div>
@endsection('main')