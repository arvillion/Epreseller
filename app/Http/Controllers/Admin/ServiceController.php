<?php

namespace App\Http\Controllers\Admin;

use App\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::paginate(10);
        return view('admin.service.index')->withServices($services);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
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

    public function changePassword($id, Request $request)
    {
        $service = Service::findOrFail($id);
        $server = $service->server;
        $easypanel = new \Easypanel($server->ip, $server->port, $server->authcode);
        $res = $easypanel->changePassword($service->user, $request->pass);
        if($res){
            $service->pass = $request->pass;
            $service->save();
        }
        return redirect()->back()->with('success', '修改状态成功');
    }

    public function changeStatus($id){
        $service = Service::findOrFail($id);
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
