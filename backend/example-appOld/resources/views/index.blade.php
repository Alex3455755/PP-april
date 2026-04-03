
@extends('layouts.base')

@section('title', 'объявления')

@section('main')
    <div class="container">
        @if (count($sales) > 0)
        <table class = "table table-striped">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Цена, руб</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            <tbody>
                @foreach ($sales as $sale)
                                <tr>
                    <td><h3>{{ $sale-> title }}</h3></td>
                    <td>{{$sale->price}}</td>
                    <td>
                        <a href='{{ route("sale.detail", ["sale" => $sale-> id ]) }}'>Ссылка</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            </tbody>
        </table>
        @endif
    </div>
@endsection('main')