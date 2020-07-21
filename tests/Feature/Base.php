<?php
/**
 *
 * @author woojuan
 * @email woojuan163@163.com
 * @copyright GPL
 * @version
 */

namespace Tests\Feature;


use App\Models\Post;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\JWTToken;

class Base extends TestCase
{
    //要引入这个trait,先刷新一下数据表,不然报错no such table
    use RefreshDatabase;
    use JWTToken;//获取用户token,并添加到header

    protected $user;

    //setUp是父类方法,这里要标明返回值类型,为void,没有返回值
    public function setUp(  ):void {
        //调用父类setup(),会在测试之前运行
        parent::setUp();
        //创建一个用户来测试
        $this->user = factory(User::class)->create();
    }

    //创建一个帖子
    public function makePost(  ) {

        $post = factory(Post::class)->create([
            'category_id' => 2,
            'user_id'     => $this->user->id,
        ]);
        return $post;
    }

    public function makeReply(  ) {
        $post = $this->makePost();
        $reply = factory(Reply::class)->create([
            'user_id' => $this->user->id,
            'post_id' => $post->id,
        ]);

        return $reply;
    }
}
