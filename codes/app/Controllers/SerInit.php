<?php
// 项目初始化脚本，会在镜像构建完成后执行
namespace App\Controllers;
use MongoDB;
use Parsedown;
use Config;

class SerInit extends BaseController
{
    use \CodeIgniter\API\ResponseTrait;
    private $DB = null;

    private function set_db(){
        $grp = config('Database')->defaultGroup;
        $db = config('Database')->$grp['database'];
        $host = sprintf(
            "mongodb://%s:%s@%s",
            config('Database')->$grp['username'],
            config('Database')->$grp['password'],
            config('Database')->$grp['hostname']
        );
        $this->DB = (new MongoDB\Client($host))->$db;
    }

    public function index()
    {
        $this->set_db();
        $this->DB->dropCollection('rotes');
        $res = $this->DB->createCollection('rotes');
        
        return $res;
    }

    public function get_env()
    {
        $grp = config('Database')->defaultGroup;
        $db = config('Database')->$grp['database'];
        $host = sprintf(
            "mongodb://%s:%s@%s",
            config('Database')->$grp['username'],
            config('Database')->$grp['password'],
            config('Database')->$grp['hostname']
        );
        $data = [
            ENVIRONMENT,
            $grp,
            $db,
            $host,
            config('Database')
        ];
        return $this->respond($data,200);
    }
}