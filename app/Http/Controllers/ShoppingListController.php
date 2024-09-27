<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Shopping_listRegisterPostRequest;
use App\Models\Shopping_list as ShoppingListModel;

class ShoppingListController extends Controller
{
    /**
     * 買い物リスト一覧ページを表示する
     */
    public function list()
    {
        // 一覧の取得
        $list = ShoppingListModel::where('user_id', Auth::id())
                                ->orderBy('name', 'ASC')
                                ->orderBy('created_at')
                                ->get();
        /*
        $sql = ShoppingListModel::where('user_id', Auth::id())
                                ->orderBy('name')
                                ->toSql();
        */
        //echo "<pre>\n"; var_dump($sql, $list); exit;
        return view('shopping_list.list', ['list' => $list]);
    }
    
    /**
     * 買うものの新規登録
     */
    public function register(Shopping_listRegisterPostRequest $request)
    {
        // validate済のデータ取得
        $datum = $request->validated();
        //
        //$user = Auth::user();
        //$id = Auth::id();
        //var_dump($datum, $user, $id); exit;
        
        // user_idの追加
        $datum['user_id'] = Auth::id();
        
        // テーブルへのINSERT
        try {
            $r = ShoppingListModel::create($datum);
        } catch(\Throwable $e) {
            // XXX 本当はログに書く等の処理をする。今回は一端「出力する」だけ
            echo $e->getMessage();
            exit;
        }
        
        // 登録成功
        $request->session()->flash('front.shopping_list_register_success', true);
        
        // リダイレクト
        return redirect('/shopping_list/list');
    }
}
