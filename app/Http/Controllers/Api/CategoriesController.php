<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * 返回分类列表,被 data 包围
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(  ) {
        $categories = Category::all();
        //返回集合资源用collection,也可以新建resourceCollection类
        return CategoryResource::collection($categories);
    }
}
