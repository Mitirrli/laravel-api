<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demo', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('int')->unsigned()->comment('整数');
            $table->char('char', 10)->default('')->comment('字符串');
            $table->integer('create_time')->unsigned()->comment('创建时间');
            $table->integer('update_time')->unsigned()->comment('更新时间');
            $table->integer('delete_time')->unsigned()->nullable()->comment('删除时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demo');
    }
}
