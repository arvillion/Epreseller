<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Server extends Model
{
    use SoftDeletes;

    protected $hidden = ['pivot'];
    protected $dates = ['deleted_at'];

    public function products()
    {
        return $this->belongsToMany('App\Product' ,'server_product');
    }

    public function services(){
        return $this->hasMany('App\Service');
    }
}
