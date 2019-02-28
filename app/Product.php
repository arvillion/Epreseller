<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'web_quota',
        'db_quota',
        'flow_limit',
        'speed_limit',
        'db_type',
        'domain',
        'subdir_flag',
        'subdir_max',
        'ftp',
        'ftp_connect',
        'ftp_usl',
        'ftp_dsl',
        'htaccess',
        'log_handle',
        'access',
        'speed_limit',
        'account_limit',
        'ssl'
    ];
    protected $hidden = ['pivot'];

    public function servers(){
        return $this->belongsToMany('App\Server', 'server_product');
    }

    public function services(){
        return $this->hasMany('App\Service');
    }

    public function roles(){
        return $this->belongsToMany('App\Role', 'role_product');
    }
}
