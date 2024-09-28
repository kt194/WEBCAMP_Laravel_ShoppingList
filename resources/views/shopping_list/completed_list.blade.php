@extends('layout')

{{-- タイトル --}}
@section('title')(詳細画面)@endsection

{{-- メインコンテンツ --}}
@section('contents')
    <h1>購入済「買うもの」一覧</h1>
        <a href="{{ route('front.list') }}">「買うもの」一覧に戻る</a><br>
        <table border="1">
        <tr>
            <th>「買うもの」名
            <th>購入日
        </tr>
    @foreach($list as $item)
        <tr>
            <td>{{ $item->name }}</td>
            <td>{{ $item->updated_at->format('Y/m/d'); }}</td>
        </tr>
    @endforeach
        </table>
        <!-- ページネーション -->
        {{-- {{ $list->links() }} --}}
        現在 {{ $list->currentPage() }} ページ目<br>
        @if ($list->onFirstPage() === false)
            <a href="{{ route('front.complete') }}">最初のページ</a>
        @else
        最初のページ
        @endif
        /
        @if ($list->previousPageUrl() !== null)
            <a href="{{ $list->previousPageUrl() }}">前に戻る</a>
        @else
            前に戻る
        @endif
        /
        @if ($list->nextPageUrl() !== null)
            <a href="{{ $list->nextPageUrl() }}">次に進む</a>
        @else
            次に進む
        @endif
        <br>
        <hr>
        <menu label="リンク">
        <a href="/logout">ログアウト</a><br>
        </menu>
@endsection