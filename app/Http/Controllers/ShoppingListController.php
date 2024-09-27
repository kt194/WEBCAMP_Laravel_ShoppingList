<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Shopping_listRegisterPostRequest;
use App\Models\Shopping_list as Shopping_listModel;

class ShoppingListController extends Controller
{
    /**
     * 買い物リスト一覧ページを表示する
     */
    public function list()
    {
        return view('shopping_list.list');
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
            $r = Shopping_listModel::create($datum);
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
