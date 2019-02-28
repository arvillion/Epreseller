<?php

namespace App\Jobs;

use App\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UnsuspendService implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $service;

    public function __construct($id)
    {
        $this->service = Service::find($id);
    }

    public function handle()
    {
        if($this->service->status == 0){
            $server = $this->service->server;
            $easypanel = new \Easypanel($server->ip, $server->port, $server->authcode);
            $res = $easypanel->updateVh($this->service->user, 0);
            if(!$res){
                throw new \Exception('Service failed to delete');
            }
        }
    }
}
