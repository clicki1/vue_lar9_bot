<?php

namespace App\Http\Controllers\Vue\Tag;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Vue\Tag\UpdateRequest;
use App\Models\Category;
use App\Models\Tag;

class UpdateController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UpdateRequest $request, Tag $tag)
    {

        $data = $request->validated();

        $tag = $this->service->updateTag($data, $tag);

        return response([]);
    }
}
