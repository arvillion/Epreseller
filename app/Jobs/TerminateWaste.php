<?php

namespace App\Jobs;

use App\Service;
use Hamcrest\Type\IsInteger;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TerminateWaste implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;
    public $timeout = 30;
    protected $service;

    public function __construct($service_id)
    {
        $this->service = Service::withTrashed()->find($service_id);
    }


    public function handle()
    {
        $server = $this->service->server;
        $easypanel = new \Easypanel($server->ip, $server->port, $server->authcode);
        $res = $easypanel->delVh($this->service->user);
        if($res){
            $this->service->forceDelete();
        }else{
            throw new \Exception('Service failed to delete');
        }
    }
}
