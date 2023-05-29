<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends BaseController
{
    public function index(Request $request)
    {
       // $value = $request->session()->pull('chat_id', 'null');
        if ($request->session()->has('chat_id')) {
            $data = $request->session()->all();
            $value = $request->session()->get('chat_id');
           // dump($value);
          //  dd($data);
        }

        return view('chat.base');
    }
    public function login(Request $request)
    {
        if ($request->session()->has('chat_id')) {
          //  dd(33333);
        }else{
            $chat_id = $request->input('chat_id');
            $request->session()->put('chat_id', $chat_id);
        }
        return redirect()->route('files.index');
    }
    public function sign()
    {
        return 'Вы вошли';
    }
    public function logout(Request $request)
    {
        $value = $request->session()->pull('chat_id', 'null');
        return redirect()->route('chat.login');
    }
}
