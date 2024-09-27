<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Shopping_listRegisterPostRequest;
use App\Models\Shopping_list as ShoppingListModel;
use Illuminate\Support\Facades\DB;
use App\Models\CompletedShoppingList as CompletedShoppingListModel; 

class ShoppingListController extends Controller
{
    /**
     * 買い物リスト一覧ページを表示する
     */
    public function list()
    {
        // 1ページあたりの表示アイテム数を設定
        $per_page = 3;
        
        // 一覧の取得
        $list = ShoppingListModel::where('user_id', Auth::id())
                                ->orderBy('name', 'ASC')
                                ->orderBy('created_at')
                                ->paginate($per_page);
                                //->get();
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
        
        // 「買い物」登録成功
        $request->session()->flash('front.shopping_list_register_success', true);
        
        // リダイレクト
        return redirect('/shopping_list/list');
    }
    
    /**
     * タスクの完了
     */
    public function complete(Request $request,$shopping_list_id)
    {
        /* タスクを完了テーブルに移動させる */
        try {
            // トランザクション開始
            DB::beginTransaction();
            
            // task_idのレコードを取得する
            $item = $this->getShoppingListModel($shopping_list_id);
            if ($item === null) {
                // shopping_list_idが不正なのでトランザクション修了
                throw new \Exception('');
            }
            //var_dump($item->toArray()); exit;
            
            // tasks側を削除する
            $item->delete();
            
            // completed_tasks側にinsertする
            $item_datum = $item->toArray();
            unset($item_datum['created_at']);
            unset($item_datum['updated_at']);
            
            $r = CompletedShoppingListModel::create($item_datum);
            if ($r === null) {
                // insertに失敗したのでトランザクション修了
                throw new \Exception('');
            }
            //echo '処理成功'; exit;
            
            // トランザクション修了
            DB::commit();
            
            // 完了メッセージ出力
            $request->session()->flash('front.shopping_list_completed_success', true);
        } catch(\Throwable $e) {
            //var_dump($e->getMessage()); exit;
            // トランザクション異常終了
            DB::rollback();
            // 完了失敗メッセージの出力
            $request->session()->flash('front.shopping_list_completed_failure', true);
        }
        
        // 一覧に遷移する
        return redirect('/shopping_list/list');
    }
    
    /**
     * 削除処理
     */
    public function delete(Request $request, $shopping_list_id)
    {
        // shoppng_list_idのレコードを取得する
        $item = $this->getShoppingListModel($shopping_list_id);
        // タスクを削除する
        if ($item !== null) {
            $item->delete();
            $request->session()->flash('front.shopping_list_delete_success', true);
        }
        
        // 一覧に遷移する
        return redirect('/shopping_list/list');
    }
    
    /**
     * 「単一のタスク」Modelの取得
     */
    protected function getShoppingListModel($shopping_list_id)
    {
        // task_idのレコードを取得する
        $item = ShoppingListModel::find($shopping_list_id);
        if ($item === null) {
            return null;
        }
        // 本人以外のタスクならNGとする
        if ($item->user_id !== Auth::id()) {
            return null;
        }
        
        return $item;
    }
}
