@extends('admin.layout')

{{-- メインコンテンツ --}}
@section('contets')
        <h1>ユーザ一覧</h1>
        <table border="1">
        <tr>
            <th>ユーザID
            <th>ユーザ名
            <th>タスク件数
    @foreach ($users as $user)
        <tr>
            <td>{{ $user->id }}
            <td>{{ $user->name }}
            <td>{{ $user->shopping_list_num }}
    @endforeach
        </table>
@endsection