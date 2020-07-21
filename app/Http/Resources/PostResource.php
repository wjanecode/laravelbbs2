<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id'    =>$this->id,
            'title' => $this->title,
            'body'  => $this->body,
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'reply_count' => $this->reply_count,
            'view_count'  => $this->view_count,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at
        ];


        $data['user'] = new UserResource($this->whenLoaded('user'));
        $data['category'] = new CategoryResource($this->whenLoaded('category'));
        $data['replies'] = new ReplyResource($this->whenLoaded('replies'));

        return $data;
    }
}
