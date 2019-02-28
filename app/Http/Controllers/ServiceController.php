<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::own()->paginate(10);
        return view('user.service.index')->withServices($services);
    }

    public function destroy($id)
    {
        $service = Service::own()->findOrFail($id);
        $server = $service->server;
        $easypanel = new \Easypanel($server->ip, $server->port, $server->authcode);
        $res = $easypanel->delVh($service->user);
        if($res){
            $service->forceDelete();
            return redirect()->back()->with('success', '删除成功');
        }else{
            return redirect()->back()->withErrors('删除失败');
        }
    }

    public function changePassword($id)
    {

    }

    public function changeStatus($id){
        $service = Service::own()->findOrFail($id);
        $server = $service->server;
        $new_status = $service->status ? 0 : 1;
        $easypanel = new \Easypanel($server->ip, $server->port, $server->authcode);
        $res = $easypanel->updateVh($service->user, $new_status);
        if($res){
            $service->status = $new_status;
            $service->save();
        }
        return redirect()->back()->with('success', '修改状态成功');
    }
}
