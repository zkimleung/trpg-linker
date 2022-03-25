<?php namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;
use MongoDB;

class RoteModel
{
    private $mongo = null;
    protected $table = "rotes";
    protected $allowedFields =[
        'profile','assets','skill','attribute'
    ];
    protected $returnType    = 'App\Entities\RoteEnt';
    protected $useTimestamps = true;
    
    private $_id = null;
    private $now = null;

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
        
        $this->now = Time::now('Asia/Shanghai', 'zh-CN');
    }

    public function getAll()
    {
        return $this->mongo->find();
    }

    public function getOne(string $id = '')
    {
        $this->setId($id);
        $doc = $this->mongo->findOne(['_id'=>$this->_id]);
        $doc['id'] = (string) $doc->_id;
        unset($doc->_id);
        return $doc;
    }

    private function setID($id)
    {
        $this->_id = new MongoDB\BSON\ObjectId($id);
    }

    public function saveOne($data, string $id = '')
    {
        if ($id) {
            $this->setId($id);
        }
        $data->update_at = $this->now->toDateTimeString();
        if (!$this->_id && !$id){
            $data->create_at =  $this->now->toDateTimeString();
            $insertOneResult = $this->mongo->insertOne($data->getEntsData());
            return $insertOneResult->getInsertedId();
        }else{
            $updateRst = $this->mongo->updateOne(
                ['_id' => $this->_id],
                ['$set' => $data]
            );
            if ($updateRst->getMatchedCount() > 0){
                return $updateRst->getModifiedCount();
            }else{
                return -1;
            }
        }
    }

    public function delOne(string $id = '')
    {
        if ($id) {
            $this->setId($id);
        }
        $deleteResult = $collection->deleteOne(['_id' => $this->_id]);
        
        if ($deleteResult->getDeletedCount()<1){
            log_message("error",$deleteResult);
        }
        return $deleteResult->isAcknowledged();
    }
}