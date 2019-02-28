<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'bandwidth', 'disk_space'];
    protected $hidden = ['pivot'];

    public function users(){
        return $this->hasMany('App\User');
    }

    public function products(){
        return $this->belongsToMany('App\Product', 'role_product');
    }
}
