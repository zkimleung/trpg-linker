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


class WebRote extends BaseController
{
    use \CodeIgniter\API\ResponseTrait;

    private $session = null;

    public function __construct(){
        $this->session = session();
    }

    public function index()
    {
        $token = $this->session->get('token');
        $Parsedown = new Parsedown();
        echo view('header',["intor" => $Parsedown->text("# 人物卡 \n > 以下调查员正在逼近或者已经疯狂......")]);
        
        helper('form');
        echo form_open('WebRote/search');
        echo form_input([
            'name'      => 'id',
            'id'        => 'rote_id',
            'placeholder '     => '人物ID',
            'maxlength' => '100'
        ]);
        echo form_submit('rote_check', '查看人物卡');
        echo form_close();

        $rote = new RoteModel();
        $list = $rote->getAll();
        $data = [];
        if ($list){
            foreach ($list as $doc){
                $id = (string) $doc->_id;
                $data[$id] = [
                    'name' => "人物名：" .$doc->profile->name,
                    'sex' => "性别：" .$doc->profile->sex,
                    'age' => "年龄：" .$doc->profile->age,
                    'PC' => "PC：" .$doc->profile->pc,
                    'ocps' => "职业编号：" .$doc->profile->occupation,
                ];
            }
            helper('html');
            echo ul($data,[
                "id" => "rotes_list",
                "class" => "ocps"
            ]);
        }
        echo view('footer');
    }

    public function search() {
        $id = $this->request->getPost('id');
        return redirect()->to('/WebRote/'.$id);
    }

    public function new()
    {
        $Parsedown = new Parsedown();
        echo view('header',["intor" => $Parsedown->text("# 人物创建")]);
        
        $ocp_mod = new OccupationModel();
        $ocps = $ocp_mod->getAll();
        $data['ocps'] = $ocps;

        echo view("webrote/roteform",$data);
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
        $data = $this->request->getPost();
        //初始化技能点
        $skill = new RoteSkillEnt();
        $skill->sycSkillByAttr($data);
        // //初始化角色背景
        $profile = new RoteProfileEnt();
        $profile->name = $data['name'];unset($data['name']);
        $profile->occupation = intval( $data['ocp']);unset($data['ocp']);
        $profile->age = intval( $data['age']);
        $profile->pc = $data['pc'];unset($data['pc']);
        $profile->sex = $data['sex'];unset($data['sex']);
        $profile->idiosyncrasy = $profile->sycIndyList();
        //初始化属性点
        $attrs = new RoteAttrEnt($data);
        $attrs->HP = $attrs->getAttrDetails('HP')['origin'];
        $attrs->MP = $attrs->getAttrDetails('MP')['origin'];
        $attrs->MOV = $attrs->getAttrDetails('MOV')['origin'];
        $attrs->Sanity = $attrs->getAttrDetails('Sanity')['origin'];
        $attrs->fill();

        //根据年龄，返回扣点规则
        $rule = $attrs->getRuleAge($data['age']);
        unset($attrs->age);
        //封装角色
        $rote = new RoteEnt();
        $rote->attribute = $attrs;
        $rote->skill = $skill;
        $rote->profile = $profile;

        // return $this->respond([$rote,$rule],200);

        $roteMod= new RoteModel();
        $id = $roteMod->saveOne($rote);
        if (!$id){
            return $this->failResourceExists($description);
        }
        $rote->id = (string) $id;
        
        return redirect()->to('/WebRote/'.$id);
    }

    public function update(string $id = '')
    {

        $roteMod= new RoteModel();
        $rote = $roteMod->getOne($id);
        if (!$rote){
            $this->failNotFound('找不到角色');
        }

        $data = $this->request->getJSON(true);
        
        $attr = new RoteAttrEnt($data['attribute']);
        foreach ($data['attribute'] as $a => $v){
            $rote->attribute->$a = $attr->$a;
        }
        
        $skill = new RoteSkillEnt($data['skill']);
        foreach ($data['skill'] as $s => $v){
            if (is_int($skill->$s)){
                $rote->skill->$s = $skill->$s;
            }elseif(is_array($v)){
                $list = $skill->fillSkillList($s,$v);
                $rote->skill->$s = $list;
            }
        }

        $profile = new RoteProfileEnt($data['profile']);
        foreach ($data['profile'] as $p => $v){
            $rote->profile->$p = $profile->$p;
        }

        $roteMod->saveOne($rote);
        
        return redirect()->to('/WebRote/'.$id);
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
        
        return $this->respond([
            'attribute' => $attr
        ],200);
    }

    public function test_funx(string $id = "")
    {
        return $id;

        // $roteMod= new RoteModel();
        // $rote = $roteMod->getOne($id);
        // if (!$rote){
        //     $this->failNotFound('找不到角色');
        // }
        return $this->respond($rote, 200);
    }
}