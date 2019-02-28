<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($this->checkStatus($request->user())){
            if($this->checkExpire($request->user())){
                return $next($request);
            }else{
                return $this->fail('1008');
            }
        }else{
            return $this->fail('1006');
        }
    }

    public function checkStatus($user){
        return $user->status == 0;
    }

    public function checkExpire($user){
        return $user->expires_at > Carbon::now();
    }

    public function fail($code){
        return response()->json([
            'code' => $code,
            'msg' => config('errorcode.msg.'.$code)
        ]);
    }
}
