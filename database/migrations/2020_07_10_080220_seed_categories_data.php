<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class SeedCategoriesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

       $data = [
           [
               'name' => '日常',
               'description' => '分享日常生活趣事'
           ],
           [
               'name' => '教程',
               'description' => '玩机教程'
           ],
           [
               'name' => '问答',
               'description' => '不懂的请在这里提问'
           ],
           [
               'name' => '公告',
               'description' => '站点公告'
           ],
       ];
       DB::table('categories')->insert($data);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        //清空表,序号都清掉,重头开始
        DB::table('categories')->truncate();
    }
}
