@extends('layout')

@section('contents')
        <h1>ログイン</h1>
        @if (session('front.user_register_success') == true)
                ユーザーを登録しました！！<br>
        @endif
        @if ($errors->any())
            <div>
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
            </div>
        @endif
        
        <form action="/login" method="post">
            @csrf
            email:<input type="email" name="email" value="{{ old('email') }}"/><br>
            パスワード:<input type="password" name="password"/><br>
            <button>ログインする</button><br>
            <a href="{{ route('user.register') }}">会員登録</a>
        </form>
@endsection