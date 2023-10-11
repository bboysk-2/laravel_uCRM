<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//controllerからviewに渡す際にInertia::render()を使うため必ず読み込む
use Inertia\Inertia;
use App\Models\InertiaTest;

class InertiaTestController extends Controller
{
    // InertiaTest経由でデータベースに保存されているデータをblogsをキーに全て取得し、'Inertia/Index'へ送る
    public function index() {
        return Inertia::render('Inertia/Index', [
            'blogs' => InertiaTest::all()
        ]);
    }

    public function create() {
        return Inertia::render('Inertia/Create');
    }

    public function show($id) {
        //dd($id);
        return Inertia::render('Inertia/Show',
        [
            'id' => $id,
            // 引数に指定したidのデータを取得
            'blog' => InertiaTest::findOrFail($id)
        ]);
    }

    public function store(Request $request) {

        // バリデーションチェック
        $request->validate([
            'title' => ['required',  'max:20'],
            'content' => ['required'],
        ]);

        // 上で読み込んだモデルをインスタンス化
        $inertiaTest = new InertiaTest;
        $inertiaTest->title = $request->title;
        $inertiaTest->content = $request->content;
        $inertiaTest->save();

        // inertia.indexにリダイレクトし、フラッシュメッセージをセッションに保存
        return to_route('inertia.index')
        ->with([
            'message' => '登録しました。'
        ]);

    }

    public function delete($id) {

        $book = InertiaTest::findOrFail($id);
        $book->delete();

        return to_route('inertia.index')
        ->with([
            'message' => '削除しました。'
        ]);
    }
}
