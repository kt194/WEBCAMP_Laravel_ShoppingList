@extends('layout')

{{-- タイトル --}}
@section('title')(詳細画面)@endsection

{{-- メインコンテンツ --}}
@section('contents')
    <h1>「買うもの」の登録</h1>
        @if (session('front.shopping_list_register_success') == true)
            「買うもの」を登録しました！！<br>
        @endif
        @if (session('front.shopping_list_delete_success') == true)
            「買うもの」を削除しました！！<br>
        @endif
        @if (session('front.shopping_list_completed_success') == true)
            「買うもの」を完了にしました！！<br>
        @endif
        @if (session('front.shopping_list_completed_failure') == true)
            「買うもの」の完了に失敗しました....<br>
        @endif
        @if ($errors->any())
            <div>
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
            </div>
        @endif 
        <form action="/shopping_list/register" method="post">
            @csrf
            「買うもの」名:<input type="text" name="name"/><br>
            <button>「買うもの」を登録する</button>
        </form>
    <h1>「買うもの」一覧</h1>
        <a href="{{ route('front.complete') }}">購入済み「買うもの」一覧</a><br>
        <table border="1">
        <tr>
            <th>登録日
            <th>「買うもの」名
        </tr>
    @foreach($list as $item)
        <tr>
            <td>{{ $item->created_at->format('Y/m/d'); }}</td>
            <td>{{ $item->name }}</td>
            <td>
                <form action="{{ route('complete', [ 'shopping_list_id' => $item->id]) }}" method="post">
                    @csrf
                    <button type="submit" onclick='return confirm("この「買うもの」を「完了」にします。よろしいですか？");' >完了</button>
                </form>
            </td>
            <td>　</td>
            <td>
                <form action="{{ route('delete', ['shopping_list_id' => $item->id]) }}" method="post">
                    @csrf
                    @method("DELETE")
                    <button type="submit" onclick='return confirm("この「買うもの」を「削除」にします。よろしいですか？");'>削除</button>
                </form>
            </td>
        </tr>
    @endforeach
        </table>
        <!-- ページネーション -->
        {{-- {{ $list->links() }} --}}
        現在 {{ $list->currentPage() }} ページ目<br>
        @if ($list->onFirstPage() === false)
            <a href="/shopping_list/list">最初のページ</a>
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