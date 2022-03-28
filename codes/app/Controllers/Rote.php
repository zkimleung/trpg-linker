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
use \App\Models\OccupationModel;


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
            $this->failNotFound('找不到角色');
        }
        return $this->respond($data, 200);
    }

    public function show(string $id = '')
    {
        //查人物
        $rote = new RoteModel();
        $data = $rote->getOne($id);
        if (!$data){
           return  $this->failNotFound('找不到角色');
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
        $profile = new RoteProfileEnt($data['profile']);
        if (empty($profile->idiosyncrasy)){
            $profile->idiosyncrasy = $profile->sycIndyList();
        }
        //根据年龄，返回扣点规则
        $rule = $attrs->getRuleAge($profile->age,(int) $data['edu_roll'],$attrs->Luck,(int) $data['luky2']);
        //封装角色
        $rote = new RoteEnt();
        $rote->attribute = $attrs;
        $rote->skill = $skill;
        $rote->profile = $profile;
        $rote->fill();

        // return $this->respond($rule,200);

        $roteMod= new RoteModel();
        $id = $roteMod->saveOne($rote);
        if (!$id){
            return $this->failResourceExists($description);
        }
        $rote->id = (string) $id;
        $ocpMod = new OccupationModel();
        return $this->respondCreated([
            "id" => (string) $id,
            "rote" => $rote,
            "upgrade_rule" => $rule
        ], 201);
    }

    public function update(string $id = '')
    {
        $data = $this->request->getJSON(true);

        $attrs = new RoteAttrEnt($data['attribute']);
        $skill = new RoteSkillEnt($data['skill']);
        $profile = new RoteProfileEnt($data['profile']);
        //封装角色
        $rote = new RoteEnt();
        $rote->attribute = $attrs;
        $rote->skill = $skill;
        $rote->profile = $profile;
        $rote->fill();

        $roteMod= new RoteModel();
        return $this->respond($rote, 200);
    }

    public function delete(string $id = '')
    {
        $rote = new RoteModel();
        $data = $rote->getOne($id);
        if (!$data){
           return  $this->failNotFound('找不到角色');
        }
        $res = $rote->delOne();
        $this->respondDeleted($data);
    }

    public function attr_upgrade()
    {
        $data = $this->request->getJSON();

        $roteMod= new RoteModel();
        $rote = $roteMod->getOne($data->id);
        if (!$rote){
            $this->failNotFound('找不到角色');
        }
        $attr = new RoteAttrEnt((array) $rote->attribute);
        foreach ($data->attribute as $a => $v){
            $rote->attribute->$a = $v;
            $attr->$a = $v;
        }
        $rote->attribute->HP = $attr->getAttrDetails('HP')['origin'];
        $rote->attribute->MP = $attr->getAttrDetails('MP')['origin'];
        $rote->attribute->MOV = $attr->getAttrDetails('MOV')['origin'];
        $rote->attribute->Sanity = $attr->getAttrDetails('Sanity')['origin'];
        $roteMod->saveOne($rote,$data->id);

        $ocp_mod = new OccupationModel();
        $res = $ocp_mod->getOcuptions();
        return $this->respond([
            'occupation_list' => $res,
            'attribute' => $attr
        ],200);
    }

    public function test_funx()
    {
        $data = $this->request->getJSON();

        $roteMod= new RoteModel();
        $rote = $roteMod->getOne($data->id);
        if (!$rote){
            $this->failNotFound('找不到角色');
        }
        $attr = new RoteAttrEnt((array) $rote->attribute);
        foreach ($data->attribute as $a => $v){
            $rote->attribute->$a = $v;
            $attr->$a = $v;
        }
        $rote->attribute->HP = $attr->getAttrDetails('HP')['origin'];
        $rote->attribute->MP = $attr->getAttrDetails('MP')['origin'];
        $rote->attribute->MOV = $attr->getAttrDetails('MOV')['origin'];
        $rote->attribute->Sanity = $attr->getAttrDetails('Sanity')['origin'];
        $roteMod->saveOne($rote,$data->id);

        $ocp_mod = new OccupationModel();
        $res = $ocp_mod->getOcuptions();
        return $this->respond([
            'occupation_list' => $res,
            'attribute' => $attr
        ],200);
    }
}