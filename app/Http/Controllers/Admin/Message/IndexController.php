<?php

namespace App\Http\Controllers\Admin\Message;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $messages = Message::paginate(10);

        return view('admin.messages.index', compact('messages'));
    }
}
