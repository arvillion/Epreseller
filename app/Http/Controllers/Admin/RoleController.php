<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SaveRole;
use App\Product;
use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::paginate(10);
        return view('admin.role.index')->withRoles($roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        return view('admin.role.create')->withProducts($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveRole $request)
    {
        $fields = $request->all();
        $fields['name'] = $fields['sname'];
        $role = Role::create($fields);
        $role->products()->sync($fields['products']);
        return redirect('admin/roles')->with('success', '创建成功');
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
        $role = Role::find($id);
        $productids = $role->products->map(function ($e){
            return $e->id;
        })->toArray();
        $products = Product::all();
        return view('admin.role.edit', ['product_ids' => $productids, 'role' => $role, 'products' => $products]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaveRole $request, $id)
    {
        $fields = $request->all();
        $fields['name'] = $fields['sname'];
        $role = Role::find($id);
        $role->fill($fields)->save();
        $role->products()->sync($fields['products']);
        return redirect('admin/roles/'.$id.'/edit')->with('success', '修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        if(!$role->users){
            $role->delete();
            return redirect()->back()->with('success', '用户组删除成功');
        }
        return redirect()->back()->withErrors('请先删除该用户组下的所有用户');
    }
}
