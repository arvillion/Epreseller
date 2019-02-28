<?php

class Easypanel{
    protected $fields = [];
    protected $url;
    protected $skey;
    protected $client;

    public function __construct($ip, $port, $skey)
    {
        $this->url = 'http://'.$ip.':'.$port.'/api/index.php';
        $this->skey = $skey;
        $this->client = new \GuzzleHttp\Client();
    }

    protected function generateFields($arr = []){
        $this->fields['c'] = 'whm';
        $this->fields['r'] = rand();
        $this->fields['s'] = md5($this->fields['a'].$this->skey.$this->fields['r']);
        $this->fields['json'] = 1;
        foreach ($arr as $key => $value){
            $this->fields[$key] = $value;
        }
    }

    protected function setAction($action){
        $this->fields['a'] = $action;
    }

    protected function sendRequest(){
        $res = $this->client->request('GET', $this->url, [
            'query' => $this->fields
        ]);
        $this->fields = [];
        $json = $res->getBody()->getContents();
        return json_decode($json);
    }

    public function addVh($name, $pass, $web_quota, $db_quota, $db_type, $subdir_flag, $max_subdir, $domain, $ftp, $ftp_connect, $ftp_usl, $ftp_dsl, $access, $speed_limit, $log_handle, $flow_limit, $htaccess, $ssl){
        $this->setAction('add_vh');
        $this->generateFields([
            'init' => 1,
            'name' => $name,
            'passwd' => $pass,
            'cdn' => 0,
            'module' => 'php',
            'web_quota' => $web_quota,
            'db_quota' => $db_quota,
            'db_type' => $db_type,
            'subdir_flag' => $subdir_flag,
            'subdir' => '',
            'max_subdir' => $max_subdir,
            'domain' => $domain,
            'ftp' => $ftp,
            'ftp_connect' => $ftp_connect,
            'ftp_usl' => $ftp_usl,
            'ftp_dsl' => $ftp_dsl,
            'access' => $access,
            'speed_limit' => $speed_limit,
            'log_handle' => $log_handle,
            'flow_limit' => $flow_limit,
            'htaccess' => $htaccess,
            'port' => $ssl ? '80,443s' : ''
        ]);
        return $this->sendRequest()->result == 200;
    }

    public function editVh($name, $pass, $web_quota, $db_quota, $db_type, $subdir_flag, $subdir, $max_subdir, $domain, $ftp, $ftp_connect, $ftp_usl, $ftp_dsl, $access, $speed_limit, $log_handle, $flow_limit, $ssl){
        $this->setAction('add_vh');
        $this->generateFields([
            'edit' => 1,
            'name' => $name,
            'passwd' => $pass,
            'cdn' => 0,
            'template' => 'php',
            'subtemplete' => '',
            'web_quota' => $web_quota,
            'db_quota' => $db_quota,
            'db_type' => $db_type,
            'subdir_flag' => $subdir_flag,
            'subdir' => '',
            'max_subdir' => $max_subdir,
            'domain' => $domain,
            'ftp' => $ftp,
            'ftp_connect' => $ftp_connect,
            'ftp_usl' => $ftp_usl,
            'ftp_dsl' => $ftp_dsl,
            'access' => $access,
            'speed_limit' => $speed_limit,
            'log_handle' => $log_handle,
            'flow_limit' => $flow_limit,
            'port' => $ssl ? '80,443s' : ''
        ]);
        return $this->sendRequest()->result == 200;
    }

    public function getVh($name){
        $this->setAction('getVh');
        $this->generateFields(['name' => $name]);
        return $this->sendRequest();
    }

    public function listVh(){
        $this->setAction('listVh');
        $this->generateFields();
        return $this->sendRequest();
    }

    public function changePassword($name, $passwd)
    {
        $this->setAction('change_password');
        $this->generateFields([
            'name' => $name,
            'passwd' => $passwd
        ]);
        return $this->sendRequest()->result == 200;

    }

    public function updateVh($name, $status){
        $this->setAction('update_vh');
        $this->generateFields([
            'name' => $name,
            'status' => $status
        ]);
        return $this->sendRequest()->result == 200;
    }

    public function delVh($name){
        $this->setAction('del_vh');
        $this->generateFields([
            'name' => $name
        ]);
        return $this->sendRequest()->result == 200;
    }

    public function getDbUsed($name){
        $this->setAction('getDbUsed');
        $this->generateFields([
            'name' => $name
        ]);
        return $this->sendRequest();
    }

}