<?php

namespace App\Controllers;
use MongoDB;
use Parsedown;
use Config;


class Rote extends BaseController
{
    use \CodeIgniter\API\ResponseTrait;
    private $DB = null;
    public function __construct(){
        $this->DB = (new MongoDB\Client)->local->rotes;
    }

    public function index()
    {
        $list = $this->DB->find();
        foreach ($list as $document) {
            // $doc[] = $document;
            echo $document['_id'];
        }
        return $this->respond($doc, 200);
    }

    public function new()
    {
        $data = [];
        return $this->respond($data, 200);
    }

    public function edit(string $id = '')
    {
        $this->failNotFound('找不到文档');
        //
    }

    public function show(string $id = '')
    {
        $data = $this->DB->findOne(['_id'=>new MongoDB\BSON\ObjectId($id)]);
        if (!$data){
           return  $this->failNotFound('找不到文档');
        }
        return $this->respond($data, 200);
    }

    public function create()
    {
        $data = $this->request->getJSON(true);
        $insertOneResult = $this->DB->insertOne($data);

        if (!$insertOneResult->getInsertedCount()){
            return $this->failResourceExists($description);
        }
        return $this->respondCreated($insertOneResult->getInsertedId(), 201);
    }

    public function update(string $id = '')
    {
        $data = $this->request->getJSON();
        return $this->respond($data, 200);
    }

    public function delete(string $id = '')
    {
        //
        $this->failResourceGone($description);
        $this->respondDeleted($data);
    }
}