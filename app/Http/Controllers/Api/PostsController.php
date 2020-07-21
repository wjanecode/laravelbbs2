<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PostsController extends ApiController
{
    /**
     * 新建帖子
     * @param PostRequest $request
     *
     * @return PostResource
     */
    public function store(PostRequest $request) {

        $user_id = $request->user()->id;

        $data = $request->only('title','body','category_id');
        $data['user_id'] = $user_id;
        $post = Post::create($data);

        return new PostResource($post);
    }

    /**
     * 更新帖子
     * @param Post $post
     * @param Request $request
     *
     * @return PostResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Post $post,Request $request) {

        //权限验证
        $this->authorize('update',$post);

        $post->update($request->all());

        return new PostResource($post);

    }

    /**删除帖子
     * @param Post $post
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Post $post) {
        $post->delete();
        return response()->json(['message'=>'删除成功'])->setStatusCode(204);
    }

    /**
     * 帖子列表
     * @param Request $request
     * @param Post $post
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request) {

        //新,使用include,可以根据url值返回需要的内容
        //使用文档:https://learnku.com/courses/laravel-advance-training/6.x/list-of-posts/5722
        //https://docs.spatie.be/laravel-query-builder/v2/introduction/
        $posts = QueryBuilder::for(Post::class)
            //?include=user,category
            //关联模型
            ->allowedIncludes('user','category','user.roles','replies')
            //?filter[title]=xxx&filter[category_id]=1&filter[withOrder]=xxxx
            //过滤字段,默认模糊搜索,exact()精确搜索,scope()范围,可以定义默认值,
            ->allowedFilters([
                'title',
                AllowedFilter::exact('category_id'),
                AllowedFilter::exact('user_id'),
                AllowedFilter::scope('withOrder')
            ])
            ->paginate(10);


//        //旧版 是否要求分类
//        if ($category = $request->get('category_id',false)){
//            $query = $query->where('category_id',$category);
//        }
//        //是否要求排序
//        if ($order = $request->get('order','false')){
//            $query = $query->withOrder($order);
//        }
//        //执行查询
//        $posts = $query->with('user','category')->paginate(10);

        return PostResource::collection($posts);
    }

    /**
     * 帖子详情
     * @param Post $post
     *
     * @return PostResource
     */
    public function show($id) {

        $post = QueryBuilder::for(Post::class)
            ->allowedIncludes('user','category','user.roles','replies')
            ->findOrFail($id);

        return new PostResource($post);
    }
}
