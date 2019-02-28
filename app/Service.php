<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    protected $fillable = ['user', 'pass', 'product_id', 'server_id', 'user_id', 'status'];
    protected $hidden = ['pivot'];
    protected $dates = ['deleted_at'];

    public function reseller(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function server(){
        return $this->belongsTo('App\Server')->withTrashed();
    }

    public function product(){
        return $this->belongsTo('App\Product');
    }

    public function scopeOwn(){
        return $this->where('user_id', \Auth::id());
    }
}
