<?php

namespace App\Http\Controllers\Vue\Tag;

use App\Http\Controllers\BaseController;
use App\Models\Tag;

class DeleteController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Tag $tag)
    {
        $tag->forceDelete();

        return response([]);
    }
}
