<?php namespace App\Models;

use MongoDB;
use \App\Entities\RoteAttrEnt;

class OccupationModel
{
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

    public function getOcuptions()
    {
        return [];
        $doc = $this->mongo->find();
        return $doc;
    }

    public function getPoints(RoteAttrEnt $attrs, int $age = 0){
        return [
            $attrs,
            $age
        ];
    }

}