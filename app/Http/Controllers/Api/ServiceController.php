<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ApiService;
use App\Http\Requests\SaveService;
use App\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function __construct()
    {

    }

    public function store(Request $request){

        \Validator::make($request->all(), [
            'user' => 'required',
            'pass' => 'required',
            'server_id' => 'required|integer',
            'product_id' => 'required|integer'
        ])->validate();

        $user = $request->input('user');
        $pass = $request->input('pass');
        $product_id = $request->input('product_id');
        $server_id = $request->input('server_id');

        $product = \Auth::user()->role->products->find($product_id);

        if(!$product){
            return $this->fail('1001');
        }

        if($product->status != 0) return $this->fail('1007');

        $server = $server_id ? $product->servers->find($server_id) : $product->servers->first();

        if(!$server){
            return $this->fail('1002');
        }

        if($server->status != 0) return $this->fail('1007');

        //check account_limit
        $cnt = Service::where('user_id', \Auth::id())->where('product_id', $product_id)->count();
        if($cnt >= $product->account_limit && $product->account_limit) return $this->fail('1005');

        $easypanel = new \Easypanel($server->ip, $server->port, $server->authcode);
        $res = $easypanel->addVh($user, $pass, $product->web_quota, $product->db_quota, $product->db_type, $product->subdir_flag, $product->subdir_max, $product->domain, $product->ftp, $product->ftp_connect, $product->ftp_usl, $product->ftp_dsl, $product->access, $product->speed_limit, $product->log_handle, $product->flow_limit, $product->htaccess, $product->ssl);

        if($res){
            $s = Service::create([
                'user' => $user,
                'pass' => $pass,
                'product_id' => $product_id,
                'user_id' => \Auth::id(),
                'server_id' => $server_id,
                'status' => 0
            ]);
            return $this->success(['service_id' => $s->id]);
        }else{
            return $this->fail('500');
        }
    }

    public function destroy($id){
        $service = Service::find($id);
        if(!$service) return $this->fail('1003');
        if($service->user_id != \Auth::id()) return $this->fail('401');
        $server = $service->server;
        $easypanel = new \Easypanel($server->ip, $server->port, $server->authcode);
        $res = $easypanel->delVh($service->user);
        if($res){
            $service->delete();
            return $this->success();
        }else{
            return $this->fail('500');
        }
    }

    public function changeStatus($id){
        $service = Service::find($id);
        if(!$service) return $this->fail('1003');
        if($service->user_id != \Auth::id()) return $this->fail('401');
        $server = $service->server;
        if($server->status != 0 || $service->product->status != 0){
            return $this->fail('1007');
        }
        $new_status = $service->status ? 0 : 1;
        $easypanel = new \Easypanel($server->ip, $server->port, $server->authcode);
        $res = $easypanel->updateVh($service->user, $new_status);
        if($res){
            $service->status = $new_status;
            $service->save();
            return $this->success(['status' => $service->status]);
        }else{
            return $this->fail('500');
        }
    }

    public function changePassword($id, Request $request){
        \Validator::make($request->all(), [
            'pass' => 'required'
        ])->validate();
        $service = Service::find($id);
        if(!$service) return $this->fail('1003');
        if($service->user_id != \Auth::id()) return $this->fail('401');
        $server = $service->server;
        $easypanel = new \Easypanel($server->ip, $server->port, $server->authcode);
        $res = $easypanel->changePassword($service->user, $request->input('pass'));
        if($res){
            $service->pass = $request->input('pass');
            $service->save();
            return $this->success();
        }else{
            return $this->fail('500');
        }
    }

    public function getServiceIdByName(Request $request){
        $service = $this->findService($request);
        if(!$service) return $this->fail('1003');
        if($service->user_id != \Auth::id()) return $this->fail('401');
        return $this->success(['service_id' => $service->id]);
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

    public function findService(Request $request){
        \Validator::make($request->all(), [
            'user' => 'required',
            'product_id' => 'required|integer',
            'server_id' => 'required|integer'
        ])->validate();
        $service = Service::where([
            ['user', $request->all('user')],
            ['server_id', $request->all('server_id')],
            ['product_id', $request->all('product_id')]
        ])->first();
        return $service;
    }
}
