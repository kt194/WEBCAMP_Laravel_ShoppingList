<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterPost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('user.register'); // 登録画面を表示
    }

    public function register(UserRegisterPost $request)
    {
        $datum = $request->validated();
        $datum['password'] = Hash::make($datum['password']); // パスワードのハッシュ化

        User::create($datum); // ユーザーをDBに登録

        // タスク登録成功
        $request->session()->flash('front.user_register_success', true);

        return redirect('/');
    }
}
