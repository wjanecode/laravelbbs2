<?php

namespace App\Http\Controllers\Api;

use App\Handlers\ImageUploadHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ImagesRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use http\Env\Response;
use Illuminate\Http\Request;

class ImagesController extends ApiController
{
    /**
     * 保存图片
     * @param ImagesRequest $request
     * @param ImageUploadHandler $handler
     *
     * @return ImageResource|\Illuminate\Http\JsonResponse
     */
    public function store(ImagesRequest $request,ImageUploadHandler $handler) {

        //dd($request->type);
        if ($file = $request->file('image') )
        {
           // dd($file);
            $image = $handler->upload($request->file('image'),$request->type,$request->type);
            $data = [
                'user_id' => auth('api')->id(),
                'type'    => $request->get('type'),
                'path'    => $image['path'],
            ];

            $image = Image::create($data);
            return new ImageResource($image);
        }

        return response()->json(['message'=>'没有上传图片,请重试',404]);
    }


}
