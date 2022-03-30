<?php namespace App\Models;

use MongoDB;
use \App\Entities\RoteAttrEnt;

class OccupationModel
{
    const LIMIT = 20;

    private $mongo = null;
    protected $table = "occupation";
    private $attrs = null;
    private $ocp_id = 1;

    public function __construct()
    {
        $grp = config('Database')->defaultGroup;
        $db = config('Database')->$grp['database'];
        $host = sprintf(
            "mongodb://%s:%s@%s",
            config('Database')->$grp['username'],
            config('Database')->$grp['password'],
            config('Database')->$grp['hostname']
        );
        $table = $this->table;
        $this->mongo = (new MongoDB\Client($host))->$db->$table;
    }

    public function getOcuptions(int $page = 1, int $limit = self::LIMIT)
    {
        $no_limit = ($page - 1) * $limit + 1;

        $doc = $this->mongo->find(
            [
                'no' => ['$gt' => $no_limit]
            ],
            [
                'limit' => $limit,
                'sort' => ['no' => 1]
            ]
        );
        return $doc;
    }

    public function getPoints(RoteAttrEnt $attrs, int $age = 0){
        return [
            $attrs,
            $age
        ];
    }

    public function count(){
        return $this->mongo->count();
    }

}