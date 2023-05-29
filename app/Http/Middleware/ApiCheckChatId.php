<?php

namespace App\Http\Middleware;

use App\Models\Chat;
use Closure;
use Illuminate\Http\Request;

class ApiCheckChatId
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->has('chat_id')) {
            $chat_id = $request->session()->get('chat_id');
            $chat = Chat::where('chat_id', $chat_id)->first();
          //  return abort(405);
            if ($chat) return $next($request);
        }
        // dd(2222);
        $request->session()->pull('chat_id', 'null');
        return abort(403);
    }
}
