<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TodoRequest;
use App\Models\Category;
use App\Models\Todo;


class TodoController extends Controller
{
    public function index()
    {
        // 1. データベースから全てのTodoを取得
        // is_archived が false（0）のものだけを表示する
        $todos = Todo::with('category')->where('is_archived', false)->get();
        $categories = Category::all();

        // 2. 取得した $todos を 'todos' という名前でビューに渡す
        return view('index', compact('todos', 'categories'));

        // deadline（期限）が早い順（昇順）に並べる
        // null（期限なし）を最後に持っていきたい場合はさらに工夫が必要ですが、まずはこれでOK！
        $todos = Todo::with('category')->orderBy('deadline', 'asc')->get();
    }

        // アーカイブ実行メソッドを追加
        public function archive(Request $request)
        {
            Todo::find($request->id)->update(['is_archived' => true]);
            return redirect('/')->with('message', 'タスクを完了しました');
        }

        public function archived()
        {
            // is_archived が true のものだけ取得
            $todos = Todo::with('category')->where('is_archived', true)->get();
            $categories = Category::all();
            return view('archived', compact('todos', 'categories'));
        }

        public function restore(Request $request)
        {
            // 一覧に戻す処理
            Todo::find($request->id)->update(['is_archived' => false]);
            return redirect()->route('todos.archived')->with('message', 'ToDoを一覧に戻しました');
        }

    /**
     * Storeアクション
     * 2. 引数の型を Request から TodoRequest に変える
     */
    public function store(TodoRequest $request)
 {
    Todo::create([
        'content' => $request->content,
        'category_id' => $request->category_id, // ここでセレクトボックスの値を使う
        'deadline' => $request->deadline,
    ]);

     // with('名前', 'メッセージ内容') を追加
     return redirect('/')->with('message', 'Todoを作成しました');
 }

    public function update(TodoRequest $request)
    {
        $todoData = $request->only(['content','deadline']);
        Todo::find($request->id)->update($todoData);

        return redirect('/')->with('message', 'Todoを更新しました');
    }

    public function destroy(Request $request)
    {
        Todo::find($request->id)->delete();

        return redirect('/')->with('message', 'Todoを削除しました');
    }

    public function search(Request $request)
{

    // 1. まず「検索の準備（クエリビルダ）」を開始する
    // ここではまだ get() しないのがポイントです！
    $query = Todo::with('category')
                ->CategorySearch($request->category_id)
                ->KeywordSearch($request->keyword);

    // ★アーカイブを含めるチェックがない場合は、未アーカイブのみ表示
    if (!$request->has('include_archived')) {
        $query->where('is_archived', false);
    }   

    // 2. 期限切れチェックが入っていたら、条件を追加する
    if ($request->has('overdue')) {
        $query->where('deadline', '<', now());
    }

    // --- ソート処理 ---
    $sort = $request->get('sort');

    if ($sort === 'desc') {
        // 期限が遠い順（期限なしを最後に）
        // deadline IS NULL は、NULLなら「1」、値があれば「0」になるので、
        // 昇順（ASC）にすれば 0(ある) -> 1(なし) の順になります。
        $query->orderByRaw('deadline IS NULL ASC')->orderBy('deadline', 'desc');
    } elseif ($sort === 'latest') {
        // 新しく作成した順
        $query->orderBy('created_at', 'desc');
    } else {
        // デフォルト：期限が近い順（期限なしを最後に）
        $query->orderByRaw('deadline IS NULL ASC')->orderBy('deadline', 'asc');
    }

    // 4. すべての条件が揃ったところで、最後にデータを取得する！
    $todos = $query->get();
    $categories = Category::all();

    return view('index', compact('todos', 'categories'));
}
    
    
}

