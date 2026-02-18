<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeadlineToTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
        {
            Schema::table('todos', function (Blueprint $table) {
            // deadlineカラムを追加（nullも許可するようにしておくのが安全です）
            $table->datetime('deadline')->nullable()->after('category_id');
        });
        }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
        {
            Schema::table('todos', function (Blueprint $table) {
                // ロールバックした時にカラムを削除する設定
                $table->dropColumn('deadline');
            });
    }
}
