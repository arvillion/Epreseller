<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\SuspendService;
use App\Jobs\TerminateWaste;
use App\Jobs\UnsuspendService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Server;
use App\Http\Requests\SaveServer;

class ServerController extends Controller
{
    protected $server;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    public function index()
    {
        $servers = Server::paginate(10);
        return view('admin.server.index', ['servers' => $servers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.server.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveServer $request)
    {
        $server = new Server;
        $server->name = $request->input('sname');
        $server->ip = $request->input('ip');
        $server->port = $request->input('port');
        $server->user = $request->input('user');
        $server->pass = $request->input('pass');
        $server->authcode = $request->input('authcode');
        if($server->save()){
            return redirect('admin/servers');
        }else{
            return redirect()->back()->withInput()->withErrors('Failed to save');
        }
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
        $server = Server::find($id);
        return view('admin.server.edit', ['server' => $server]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaveServer $request, $id)
    {
        $server = Server::find($id);
        $server->name = $request->input('sname');
        $server->ip = $request->input('ip');
        $server->port = $request->input('port');
        $server->user = $request->input('user');
        $server->pass = $request->input('pass');
        $server->authcode = $request->input('authcode');
        if($server->save()){
            return redirect('admin/servers');
        }else{
            return redirect()->back()->withInput()->withErrors('Failed to update');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $server = Server::findOrFail($id);
        $services = $server->services;
        $server->products()->detach();
        if($services){
            foreach($services as $service){
                TerminateWaste::dispatch($service->id);
            }
            $server->services()->delete(); //soft delete
        }
        $server->delete(); //soft delete

        return redirect()->back()->with('success', '删除成功!');
    }

    public function suspend($id){
        $server = Server::findOrFail($id);
        $server->status = 1;
        $server->save();
        $server->services()->update([
            'status' => -1
        ]);
        $services = $server->services;
        foreach($services as $service){
            SuspendService::dispatch($service->id);
        }
        return redirect()->back()->with('success', '服务器暂停成功');
    }

    public function unSuspend($id){
        $server = Server::findOrFail($id);
        $server->status = 0;
        $server->save();
        $server->services()->update([
            'status' => 0
        ]);
        $services = $server->services;
        foreach($services as $service){
            UnsuspendService::dispatch($service->id);
        }
        return redirect()->back()->with('success', '服务器恢复成功');
    }
}
