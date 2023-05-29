<?php

namespace App\Http\Controllers\Vue\Result;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Result\ResultResourse;
use App\Models\Result;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $limit = 10;
        if($request->input('limit')){
           $limit = $request->input('limit');
        }
        $chat_id = $request->session()->get('chat_id');
        $results =  Result::orderByDesc('id')
            ->where('chat_id', $chat_id)
            ->take($limit)
            ->get();
      //  return json_encode($messages);
        return ResultResourse::collection($results);
    }
}
