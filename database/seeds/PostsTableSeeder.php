<?php

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostsTableSeeder extends Seeder
{
    public function run()
    {
        //取出用户id数组
        $user_ids = \App\Models\User::all()->pluck('id')->toArray();
        //取出分类id数组
        $category_ids = \App\Models\Category::all()->pluck('id')->toArray();

        $posts = factory(Post::class)->times(1000)->make()->each(function ($post, $index) use ($user_ids,$category_ids) {

            //分配随机用户和分类
            $post->user_id = $user_ids[array_rand($user_ids)];
            $post->category_id = $category_ids[array_rand($category_ids)];

        })->toArray();

        Post::insert($posts);

        //数据太多要分批插入,不然mysql会出错
        $posts = factory(Post::class)->times(1000)->make()->each(function ($post, $index) use ($user_ids,$category_ids) {

            //分配随机用户和分类
            $post->user_id = $user_ids[array_rand($user_ids)];
            $post->category_id = $category_ids[array_rand($category_ids)];

        })->toArray();

        Post::insert($posts);

        //数据太多要分批插入,不然mysql会出错
        $posts = factory(Post::class)->times(1000)->make()->each(function ($post, $index) use ($user_ids,$category_ids) {

            //分配随机用户和分类
            $post->user_id = $user_ids[array_rand($user_ids)];
            $post->category_id = $category_ids[array_rand($category_ids)];

        })->toArray();

        Post::insert($posts);


    }

}

