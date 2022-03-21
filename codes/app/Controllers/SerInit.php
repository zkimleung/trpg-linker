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
    public function __construct(){
        $grp = config('database')->defaultGroup;
        $db = config('database')->$grp['database'];
        $host = sprintf(
            "mongodb://%s:%s@%s",
            config('database')->$grp['username'],
            config('database')->$grp['password'],
            config('database')->$grp['hostname']
        );
        $this->DB = (new MongoDB\Client($host))->$db;
    }

    public function index()
    {
        $res = $this->DB->createCollection('rotes');
    }

    public function dropTable()
    {
        return $this->DB->dropCollection('rotes');
    }

    public function getEnv()
    {
        $grp = config('database')->defaultGroup;
        $db = config('database')->$grp['database'];
        $host = sprintf(
            "mongodb://%s:%s@%s",
            config('database')->$grp['username'],
            config('database')->$grp['password'],
            config('database')->$grp['hostname']
        );
        $data = [
            ENVIRONMENT,
            $grp,
            $db,
            $host
        ];
        return $this->respond($data,200);
    }
}