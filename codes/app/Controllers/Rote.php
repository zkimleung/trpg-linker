<?php

namespace App\Controllers;
use MongoDB;
use Parsedown;
use Config;
use \App\Entities\RoteEnt;
use \App\Models\RoteModel;


class Rote extends BaseController
{
    use \CodeIgniter\API\ResponseTrait;
    private $DB = null;

    public function index()
    {
        $rote = new RoteModel();
        $list = $rote->getAll();
        return $this->respond($list, 200);
    }

    public function new()
    {
        $data = [];
        return $this->respond($data, 200);
    }

    public function edit(string $id = '')
    {
        $this->failNotFound('找不到文档');
    }

    public function show(string $id = '')
    {
        $rote = new RoteModel();
        $data = $rote->getOne($id);
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
        $rote = new RoteModel();
        $data = $rote->getOne($id);
        $this->respondDeleted($data);
    }
}