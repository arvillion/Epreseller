<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\SuspendService;
use App\Jobs\TerminateWaste;
use App\Jobs\UnsuspendService;
use App\Server;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Http\Requests\SaveProduct;

class ProductController extends Controller
{
    public function index(){
        $products = Product::paginate(10);
        return view('admin.product.index', ['products' => $products]);
    }

    public function create(){
        $servers = Server::all();

        return view('admin.product.create')->withServers($servers);
    }
    public function store(SaveProduct $request){
        $fields = $request->all();
        $fields['htaccess'] = $request->input('htaccess', 0);
        $fields['log_handle'] = $request->input('log_handle', 0);
        $fields['access'] = $request->input('access', 0);
        $fields['ssl'] = $request->input('ssl', 0);
        $fields['name'] = $fields['sname'];
        $product = Product::create($fields);
        $product->servers()->sync($request->input('servers'));
        if($product){
            return redirect('admin/products')->withSuccess('保存成功');
        }else{
            return redirect()->back()->withErrors('Failed to save')->withInput();
        }
    }
    public function show($id){
        $product = Product::findOrFail($id);
        $servers = $product->servers;
        return view('admin.product.show', ['product' => $product, 'servers' => $servers]);
    }
    public function edit($id){
        $product = Product::findOrFail($id);
        $servers = Server::all();
        $serverids = $product->servers->map(function ($s){
            return $s->id;
        })->toArray();
        return view('admin.product.edit', ['product' => $product, 'servers' => $servers, 'serverids' => $serverids]);
    }
    public function update($id, SaveProduct $request){
        $product = Product::findOrFail($id);
        $fields = $request->all();
        $fields['htaccess'] = $request->input('htaccess', 0);
        $fields['log_handle'] = $request->input('log_handle', 0);
        $fields['access'] = $request->input('access', 0);
        $fields['name'] = $request->input('sname');
        $fields['ssl'] = $request->input('ssl', 0);
        $product->fill($fields)->save();
        $product->servers()->sync($request->input('servers'));
        return redirect('admin/products')->with('success', "更新成功");
    }
    public function destroy($id){
        $product = Product::findOrFail($id);
        $product->roles()->detach();
        $product->servers()->detach();
        $services = $product->services;
        if($services){
            foreach($services as $service){
                TerminateWaste::dispatch($service->id);
            }
            $product->services()->delete(); //soft delete
        }
        $product->delete();
        return redirect()->back()->with('success', '删除成功');
    }

    public function suspend($id){
        $product = Product::findOrFail($id);
        $product->status = 1;
        $product->save();
        $product->services()->update([
            'status' => -1
        ]);
        $services = $product->services;
        foreach($services as $service){
            SuspendService::dispatch($service->id);
        }
        return redirect()->back()->with('success', '产品暂停成功');
    }

    public function unSuspend($id){
        $product = Product::findOrFail($id);
        $product->status = 0;
        $product->save();
        $product->services()->update([
            'status' => 0
        ]);
        $services = $product->services;
        foreach($services as $service){
            UnsuspendService::dispatch($service->id);
        }
        return redirect()->back()->with('success', '产品恢复成功');
    }
}
