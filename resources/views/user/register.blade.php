@extends('layout')

{{-- タイトル --}}
@section('title')(ユーザー登録)@endsection

{{-- メインコンテンツ --}}
@section('contents')
        <h1>ユーザー登録</h1>
            @if ($errors->any())
                <div>
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
                </div>
            @endif
            <form action="{{ route('user.register.post') }}" method="post">
                @csrf
                名前:<input name="name" value="{{ old('name') }}"><br>
                email:<input name="email" type="emeil" value="{{ old('email') }}"><br>
                パスワード:<input name="password" type="password">{{ old('password') }}<br>
                パスワード(再度):<input name="password_confirmation" type="password"><br>
                <button>登録する</button>
            </form>
@endsection