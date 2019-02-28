<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SaveUser;
use App\Jobs\SuspendService;
use App\Jobs\TerminateWaste;
use App\Jobs\UnsuspendService;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.user.index')->withUsers($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.user.create')->withRoles($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveUser $request)
    {
        $fields = $request->all();
        \Validator::make($fields, [
            'password' => 'required|string|min:6',
        ])->validate();
        $fields['name'] = $fields['sname'];
        $fields['role_id'] = $fields['user_role'];
        $fields['password'] = bcrypt($fields['password']);
        $fields['api_token'] = str_random(60);
        User::create($fields);
        return redirect()->route('admin.users.index')->with('success', '创建成功');
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
        $roles = Role::all();
        $user = User::find($id);
        return view('admin.user.edit', ['roles' => $roles, 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaveUser $request, $id)
    {
        $fields = $request->all();
        $fields['name'] = $fields['sname'];
        $fields['role_id'] = $fields['user_role'];
        $user = User::findOrFail($id);
        $user->fill($fields)->save();
        return redirect()->back()->with('success', '更新成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $services = $user->services;
        if($services){
            foreach($services as $service){
                TerminateWaste::dispatch($service->id);
            }
            $user->services()->delete(); //soft delete
        }
        $user->delete();
        return redirect()->back()->with('success', '删除成功');
    }

    public function changePassword(Request $request, $id){
        $fields = $request->all();
        \Validator::make($fields, [
            'password' => 'required|string|min:6',
        ])->validate();
        $user = User::findOrFail($id);
        $user->password = bcrypt($fields['password']);
        $user->save();
        return redirect()->back()->with('success', '密码修改成功');
    }

    public function suspend($id){
        $user = User::findOrFail($id);
        $user->status = 1;
        $user->save();
        $user->services()->update([
            'status' => 1
        ]);
        $services = $user->services;
        foreach($services as $service){
            SuspendService::dispatch($service->id);
        }
        return redirect()->back()->with('success', '账户暂停成功');
    }

    public function unSuspend($id){
        $user = User::findOrFail($id);
        $user->status = 0;
        $user->save();
        $user->services()->update([
            'status' => 0
        ]);
        $services = $user->services;
        foreach($services as $service){
            UnsuspendService::dispatch($service->id);
        }
        return redirect()->back()->with('success', '账户恢复成功');
    }

    public function updateExpiresAt(Request $request, $id){
        \Validator::make($request->all(), [
            'months' => 'required|integer',
        ]);
        $user = User::find($id);
        $user->expires_at = $user->expires_at->addMonths($request->months);
        $user->save();
        return redirect()->back()->with('success', '续期成功');
    }
}
