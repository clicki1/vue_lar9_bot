<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatloginContorller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       //  $value = $request->session()->pull('chat_id', 'null');
        if ($request->session()->has('chat_id')) {
            $data = $request->session()->all();
            $chat_id = $request->session()->get('chat_id');
            // dump($value);
            //  dd($data);
            return response([
                'ok' => true,
                'chat_id' => $chat_id
            ]);
        }
        return abort(403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        if ($request->session()->has('chat_id')) {
          //  $value = $request->session()->pull('chat_id', 'null');
            $chat = Chat::where('chat_id', $request->session()->get('chat_id'))->first();
            if ($chat) {
                return response([
                    'ok' => true,
                    'chat_id' => $request->session()->get('chat_id'),
                    'id' => $chat->id
                ]);
            }

            return response([
                'ok' => false,
                'chat_id' => null
            ]);
        } else {
            $chat_id = $request->input('chat_id');
            $chat = Chat::where('chat_id', $chat_id)->first();
            if ($chat) {
                $request->session()->put('chat_id', $chat_id);
                return response([
                    'ok' => true,
                    'chat_id' => $request->session()->get('chat_id'),
                    'id' => $chat->id
                ]);
            }

        }

        return response([
            'ok' => false,
            'chat_id' => null
        ]);
    }

    public function logout(Request $request){
        $request->session()->pull('chat_id', 'null');
        return response([
            'ok' => false,
            'chat_id' => null
        ]);
    }

    public function loginkey(Request $request){

        if ($request->session()->has('chat_id')) {
            //  $value = $request->session()->pull('chat_id', 'null');
            $chat = Chat::where('chat_id', $request->session()->get('chat_id'))->first();
            if ($chat) {
                return response([
                    'ok' => true,
                    'chat_id' => $request->session()->get('chat_id'),
                    'id' => $chat->id
                ]);
            }

            return response([
                'ok' => false,
                'chat_id' => null
            ]);
        } else {
            $key = $request->input('key');
            $chat = Chat::where('key', $key)->first();
            if ($chat) {
                $request->session()->put('chat_id', $chat->chat_id);
                return response([
                    'ok' => true,
                    'chat_id' => $request->session()->get('chat_id'),
                    'id' => $chat->id
                ]);
            }else{
                return response([
                    'ok' => false,
                    'chat_id' => null
                ]);
            }

        }

        return response([
            'ok' => false,
            'chat_id' => null
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
