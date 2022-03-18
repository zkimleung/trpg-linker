<?php namespace App\Models;

use CodeIgniter\Model;
use MongoDB;

class RoteModel extends Model
{
    private $DB = null;

    private $_id = null;

    public function __construct()
    {
        $this->DB = (new MongoDB\Client(
            "mongodb://root:trpg_linker@trpg-linker_mongo_1.test-net:27017"
            ))->local->rotes;
    }

    public function getOne(string $id = '')
    {
        $this->setId($id);
        return $this->DB->findOne(['_id'=>$this->_id]);
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
        if (!$this->_id && !$id){
            $insertOneResult = $this->DB->insertOne($data);
            return $insertOneResult->getInsertedId();
        }else{
            $updateRst = $this->DB->updateOne(
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
        $this->setId($id);
        $deleteResult = $collection->deleteOne(['_id' => $this->_id]);
        return $deleteResult->getDeletedCount();
    }
}