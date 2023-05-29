<?php

namespace App\Http\Controllers;

use App\Http\Filters\MessageFilter;
use App\Http\Requests\MessageRequest;
use App\Http\Requests\Vue\Message\FilterRequest;
use App\Models\Category;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Result;
use App\Models\Tag;

class MessageController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FilterRequest $request)
    {
        $data = $request->validated();

        $filter = app()->make(MessageFilter::class, ['queryParams'=> array_filter($data)]);
        $messages = Message::filter($filter)->paginate(10);
        $chat = Chat::first();


        return view('messages.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('messages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(MessageRequest $request)
    {
       // dd(222);
        $data = $request->validated();
        $mess = $this->service->storeMessageNew($data);
       // dd($message);
//
//        $message = mb_strtolower(($data['message'] ? $data['message'] : $data['message']), 'utf-8');
//        $new_arr = explode(" ", $message);
//        $res_str = '';
//        $res_num = '';
//        $cat = null;
//        $tag = null;
//
//
//        foreach ($new_arr as $arr) {
//
//            $cat = Category::where('title', $arr)->first();
//            if (!$cat) {
//                $tag = Tag::where('title', $arr)->first();
//
//                if ($tag && !$cat) {
//                    $cat = $tag->category;
//                }
//            }
//
//
//            !is_numeric($arr) ? $res_str .= "\r\n" . $arr : $res_num = $arr;
//            // $res .= '-'.$arr;
//        }
//
//        //dd($cat);
//        $mess = Message::create($data);
//
//        $res = new Result();
//        $res->coast = $res_num;
//        $res->message_id = $mess->id;
//        if ($cat) {
//            $res->category_id = $cat->id;
//        }
//
//        $res->save();

        return redirect()->route('messages.index')->with('info', $mess[0])->with('data', $mess[1]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Message $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //dd($message->result->coast);
        return view('messages.show', compact('message'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Message $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Message $message
     * @return \Illuminate\Http\Response
     */
    public function update(MessageRequest $request, Message $message)
    {
        $data = $request->validated();

        $res = $this->service->updateMessageNew($data, $message);
       // dd($res);
        return redirect()->route('messages.show', $message->id)->with('success', $message->id)->with('info', $res[0]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Message $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $message->results()->delete();
        $message->delete();

        return redirect()->route('messages.index');
    }
}
