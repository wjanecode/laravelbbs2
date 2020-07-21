<?php

namespace Tests\Feature;

use App\Handlers\MarkdownHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\JWTToken;

class RepliesApiTest extends Base
{
    use RefreshDatabase;


    /**
     * 测试新建回复
     *
     * @return void
     */
    public function testRepliesStore(  ) {

        $post = $this->makePost();
        //测试数据
        $data = ['content' => '算得上是所'];
        $data['post_id']   = $post->id;
        $data['user_id']   = $this->user->id;

        //发起请求
        $response = $this->headerWithToken($this->user)
            ->json('POST','api/v1/replies/',$data);

        //断言数据
        $handle = new MarkdownHandler();
        $assertData = [
            //设了content属性访问器,取出的数据转为HTML,这里也转一下才能对比
            'content' => $handle->convertMarkdownToHtml('算得上是所'),
            'post_id' => $post->id,
            'user_id' => $this->user->id,
        ];

        //断言
        $response->assertStatus(201)
            ->assertJsonFragment($assertData);
   }

    /**
     *    测试删除回复
     */
    public function testRepliesDestroy(  ) {
        $reply = $this->makeReply();

        $response = $this->headerWithToken($this->user)
            ->json('DELETE','api/v1/replies/' . $reply->id);
        $response->assertStatus(204);
   }


}
