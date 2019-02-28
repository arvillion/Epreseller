<?php

namespace App\Http\Controllers\Api;

use App\Server;
use App\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PanelController extends Controller
{
    public function userLogin(Request $request){
        $server_id = $request->input('server_id');
        $server = Server::find($server_id);
        if(!$server) return $this->fail('1004');
        $url = 'http://'.$server->ip.':'.$server->port;
        $user = $request->input('user');
        $pass = $request->input('pass');
        return view('user.panel.login', ['url' => $url, 'user' => $user, 'pass' => $pass]);
    }

    public function success($data = []){
        return response()->json([
            'code' => 200,
            'msg' => config('errorcode.msg')['200'],
            'data' => $data
        ]);
    }

    public function fail($code, $data = []){
        return response()->json([
            'code' => $code,
            'msg' => config('errorcode.msg')[$code],
            'data' => $data
        ]);
    }
}
