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

    private $collections = [
        'rotes'
    ];

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
        foreach ($this->collections as $col){
            $this->DB->dropCollection($col);
            $res[$col] = $this->DB->createCollection($col);
        }

        return $this->respond($res,200);
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