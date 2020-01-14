<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection //記事ひとつではなくコレクション
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,//collectionはPost.phpの記事の全体を指す。のようなことを言っていた
            'links' => [
                'self' => url('/posts'),
            ]
            ];
    }
}
