<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category; // Categoryモデルを使えるようにインポート
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    // カテゴリ一覧画面の表示
    public function index()
    {
        $categories = Category::all();
        return view('category', compact('categories'));
    }

    // 新しいカテゴリの保存処理
    public function store(CategoryRequest $request)
    {
        // 1. バリデーション（入力チェック）
        $request->validate([
            'name' => 'required|string|max:10',],// 10文字以内、必須 
            [
            // ここにカスタムメッセージを書く
            'name.required' => 'カテゴリ名を入力してください。',
            'name.max'      => 'カテゴリ名は10文字以内で入力してください。',
            ]);

        // 2. データベースへ保存
        Category::create([
            'name' => $request->name]);

        // 3. 元の画面に戻る（メッセージ付き）
        return redirect('/categories')->with('message', 'カテゴリを作成しました');
    }

        public function update(CategoryRequest $request)
    {
        $category = $request->only(['name']);
        Category::find($request->id)->update($category);

        return redirect('/categories')->with('message', 'カテゴリを更新しました');
    }

        public function destroy(Request $request)
    {
        Category::find($request->id)->delete();

        return redirect('/categories')->with('message', 'カテゴリを削除しました');
    }
}
