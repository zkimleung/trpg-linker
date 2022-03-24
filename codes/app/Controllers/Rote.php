<?php

namespace App\Controllers;
use MongoDB;
use Parsedown;
use Config;
use \App\Entities\RoteEnt;
use \App\Entities\RoteAttrEnt;
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
        $rote = new RoteModel();
        $data = $rote->getOne($id);
        if (!$data){
            $this->failNotFound('找不到文档');
        }
        return $this->respond($data, 200);
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
        $roteMod= new RoteModel();
        $data = $this->request->getJSON(true);
        
        $attrs = new RoteAttrEnt($data['attribute']);
        $attrs->HP = $attrs->getAttrDetails('HP')['origin'];
        $attrs->MP = $attrs->getAttrDetails('MP')['origin'];
        $attrs->MOV = $attrs->getAttrDetails('MOV')['origin'];
        $attrs->Sanity = $attrs->getAttrDetails('Sanity')['origin'];
        $extend = $attrs->setAge(49,70,75,85);
        return $this->respond($extend, 200);
    
        
        $rote = new RoteEnt();
        $rote->fill($data);
        $rote->attribute = $attrs;
        $id = $roteMod->saveOne($rote);
        if (!$id){
            return $this->failResourceExists($description);
        }
        return $this->respondCreated([
            "id" => (string) $id,
            "change_role" => $extend
        ], 201);
    }

    public function update(string $id = '')
    {
        $roteMod= new RoteModel();
        $data = $this->request->getJSON(true);
        
        $attrs = new RoteAttrEnt($data['attribute']);

        return $this->respond($attrs, 200);
    }

    public function delete(string $id = '')
    {
        $rote = new RoteModel();
        $data = $rote->getOne($id);
        if (!$data){
           return  $this->failNotFound('找不到文档');
        }
        $res = $rote->delOne();
        $this->respondDeleted($data);
    }
}