<?php

namespace App\Http\Middleware\V1;

use App\Models\V1\Board;
use Closure;
use Illuminate\Http\Request;

class RightsCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $board_id = $request->id;

        $res = Board::where('id', $board_id)->where('user_id', $user->id)->first();

        if(is_null($res)) {
            return response('pizda', 404);
        }


//        if ($request->input('token') !== 'my-secret-token') {
//            return redirect('home');
//        }

        return $next($request);
    }
}
