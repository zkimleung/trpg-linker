<?php

namespace App\Controllers;
use Parsedown;
use Config;

use \App\Entities\RoteEnt;
use \App\Entities\RoteAttrEnt;
use \App\Entities\RoteSkillEnt;
use \App\Entities\RoteProfileEnt;

use \App\Models\RoteModel;
use \App\Models\SkillTreeModel;


class Rote extends BaseController
{
    use \CodeIgniter\API\ResponseTrait;

    public function index()
    {
        $rote = new RoteModel();
        $list = $rote->getAll();
        return $this->respond($list, 200);
    }

    public function new()
    {
        //技能树
        $tree_mod = new SkillTreeModel();
        $data = $tree_mod->getTree();
        return $this->respond($data, 200);
    }

    public function edit(string $id = '')
    {
        //查人物
        $rote = new RoteModel();
        $data = $rote->getOne($id);
        if (!$data){
            $this->failNotFound('找不到文档');
        }
        return $this->respond($data, 200);
    }

    public function show(string $id = '')
    {
        //查人物
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
        //初始化属性点
        $attrs = new RoteAttrEnt($data['attribute']);
        $attrs->HP = $attrs->getAttrDetails('HP')['origin'];
        $attrs->MP = $attrs->getAttrDetails('MP')['origin'];
        $attrs->MOV = $attrs->getAttrDetails('MOV')['origin'];
        $attrs->Sanity = $attrs->getAttrDetails('Sanity')['origin'];
        //初始化技能点
        $tree_mod = new SkillTreeModel();
        $skill = new RoteSkillEnt();
        $tree = $tree_mod->getTree();
        foreach($data['skill'] as $keywork => $obj){
            if (is_object($tree->$keywork)){
                $skill->setSkillList($keywork,(array) $tree->$keywork);
            };
            if(is_array($obj)){
                $list = $skill->fillSkillList($keywork,$obj);
                $skill->$keywork = $list;
            }else{
                $skill->$keywork = $obj;
            }
        }
        $skill->sycSkillByAttr($data['attribute']);
        //初始化角色背景
        $profile = new RoteProfileEnt();
        $profile->idiosyncrasy = $profile->sycIndyList();
        //封装角色
        $rote = new RoteEnt();
        $rote->attribute = $attrs;
        $rote->skill = $skill;
        $rote->profile = $profile;
        $rote->fill();

        // return $this->respond($rote,200);

        $roteMod= new RoteModel();
        $id = $roteMod->saveOne($rote);
        if (!$id){
            return $this->failResourceExists($description);
        }
        $rote->id = (string) $id;
        return $this->respondCreated([
            "id" => (string) $id,
            "rote" => $rote
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

    public function test_funx()
    {
        $tree_mod = new SkillTreeModel();
        $tree = $tree_mod->getTree();
        $data = $this->request->getJSON(true);
        $res = new RoteSkillEnt();
        foreach($data as $keywork => $obj){
            if (is_object($tree->$keywork)){
                $res->setSkillList($keywork,(array) $tree->$keywork);
            }
            if(is_array($obj)){
                $list = $res->fillSkillList($keywork,$obj);
                $res->$keywork = $list;
            }else{
                $res->$keywork = $obj;
            }
        }
        return $this->respond($res,200);
    }
}