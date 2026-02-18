# laravel-docker-template
# Todo管理アプリ（アーカイブ機能付き）

日々のタスクを管理するためのシンプルなToDoアプリです。
直感的なUIと、タスクの整理に便利なアーカイブ機能を搭載しています。

## ✨ 主な機能
- **ToDo管理**: 登録、編集、削除の基本機能。
- **カテゴリ分類**: カテゴリごとの検索が可能。
- **アーカイブ機能**: 完了したタスクを一覧から隠し、専用ページで管理。
- **期限管理**: 期限切れタスクを自動で強調表示（赤字）。
- **検索・ソート**: キーワード、カテゴリ、期限切れ、アーカイブを含む検索に対応。
- <img width="1866" height="814" alt="image" src="https://github.com/user-attachments/assets/43d85f6d-650b-4466-a8ed-a81567531728" />

## 🛠 開発環境
- **Todoアプリトップ**: http://localhost/
- **アーカイブ一覧**: http://localhost/todos/archived
- **カテゴリー一覧**: http://localhost/categories

## 🛠 使用技術
- **Backend**: PHP 8.x / Laravel 10.x
- **Frontend**: Blade, CSS (Flexbox), JavaScript
- **Database**: MySQL 8.0
- **Infrastructure**: Docker / Docker Compose
- **Libraries**: Carbon (日付操作)

## 🚀 セットアップ方法

```bash
# リポジトリをクローン
git clone [https://github.com/sayu-kichi/todo.git](https://github.com/sayu-kichi/todo.git)
cd todo

# Dockerコンテナの起動
docker-compose up -d

# ライブラリのインストール
docker-compose exec app composer install

# データベースのマイグレーション
docker-compose exec app php artisan migrate
