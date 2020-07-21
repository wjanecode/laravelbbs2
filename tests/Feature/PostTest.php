<?php

namespace Tests\Feature;

use App\Handlers\MarkdownHandler;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\JWTToken;

class PostTest extends Base
{
    //测试新建帖子
    public function testPostStore(  ) {

        //帖子数据
        $data = ['category_id'=>1,'title'=>'dsafds','body'=>'sdfdddddddddd'];
        $data['user_id'] = $this->user->id;

        //发帖需要的token值
        $token = auth('api')->fromUser($this->user);

        logger(['sss'=>$token]);

        //执行请求,header携带token,返回response
        $response = $this->withHeaders(['Authorization'=>'Bearer ' . $token])
            //请求的信息
                         ->json('POST','/api/v1/posts',$data);
        //断言数据
        $handle = new MarkdownHandler();
        $assertData = [
            'category_id'=>1,
            'title'=>'dsafds',
            //Post中设了body属性访问器,取出的数据转为HTML,这里也转一下才能对比
            'body' => $handle->convertMarkdownToHtml('sdfdddddddddd'),
            'user_id' => $this->user->id
        ];

        //断言状态码,和json片段
        $response->assertStatus(201)
            ->assertJsonFragment($assertData);
    }

    //测试更新
    public function testPostUpdate(  ) {
        $post = $this->makePost();
        //更新所需数据
        $data = ['category_id'=>2,'title'=>'dsfsdfd','body'=>'sdfdsagfdgsas'];

        //发送请求
        $response = $this->headerWithToken($this->user)
        ->json('PATCH','api/v1/posts/' . $post->id,$data);

        //断言数据
        $handle = new MarkdownHandler();
        $assertData = [
            'category_id'=>2,
            'title'=>'dsfsdfd',
            'body'=> $handle->convertMarkdownToHtml('sdfdsagfdgsas')
        ];

        //断言
        $response->assertStatus(200)
            ->assertJsonFragment($assertData);
    }

    //测试删除
    public function testDestroyPost(  ) {

        $post = $this->makePost();
        $response = $this->headerWithToken($this->user)
            ->json('DELETE','api/v1/posts/' . $post->id);
        $response->assertStatus(204);

        //确认是否已删除
        $response = $this->json('GET','api/v1/posts/' . $post->id);
        $response->assertStatus(404);
    }

    //创建一个帖子
    public function makePost(  ) {

        $post = factory(Post::class)->create([
            'category_id' => 2,
            'user_id'     => $this->user->id,
        ]);
        return $post;
    }






}
