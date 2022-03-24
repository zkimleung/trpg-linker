<?php namespace App\Models;

use MongoDB;

class SkillTreeModel
{
    private $mongo = null;
    protected $table = "skill_tree";

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

    public function getTree()
    {
        $doc = $this->mongo->findOne();
        unset($doc->_id);
        return $doc;
    }

}