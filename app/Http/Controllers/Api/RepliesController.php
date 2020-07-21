<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ReplyRequest;
use App\Http\Resources\ReplyResource;
use App\Models\Reply;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class RepliesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $replies = QueryBuilder::for(Reply::class)
            //url 关联
            ->allowedIncludes('user','post','post.user')
            //url 过滤
            ->allowedFilters([
                //根据内容模糊搜索
                'content',
                //精准过滤,user_id = xxx,post_id = xxx
                AllowedFilter::exact('user_id'),
                AllowedFilter::exact('post_id'),
                //作用域,这里是recent排序,取最新回复
                AllowedFilter::scope('recent')
            ])
            ->paginate(10);

        return ReplyResource::collection($replies);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReplyRequest $request)
    {
        //
        $data= [
          'user_id' => auth('api')->id(),
          'post_id' => $request->get('post_id'),
          'content' => $request->get('content'),
        ];

        $reply = Reply::create($data);

        return new ReplyResource($reply);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        //检查权限
        $this->authorize('destroy',$reply);

        $reply->delete();
        return response('',204);

    }
}
