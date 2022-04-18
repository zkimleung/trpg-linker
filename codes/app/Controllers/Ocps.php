<?php

namespace App\Controllers;
use Config;
use Parsedown;

use \App\Models\OccupationModel;


class Ocps extends BaseController
{
    use \CodeIgniter\API\ResponseTrait;

    public function lists(int $page = 1)
    {
        $Parsedown = new Parsedown();
        echo view('header',["intor" => $Parsedown->text("# COC7版-职业表")]);

        $data = [];
        $ocp_mod = new OccupationModel();
        $res = $ocp_mod->getOcuptions($page);
        $count = $ocp_mod->count();
        foreach ($res as $doc){
            $data[$doc->name] = [
                "序号：".$doc->no,
                "信用评级：".$doc->credit,
                "属性属性：".$doc->attrs,
                "技能点：".$doc->points,
                "本职技能：".$doc->ocp_skill
            ];
        }
        helper('html');
        echo ul($data,[
            "id" => "ocps_list",
            "class" => "ocps"
        ]);
        $pager = service('pager');
        echo $pager->makeLinks($page, 20, $count,'default_full',3);
        echo view('footer');
    }

    public function test_view(){
        $Parsedown = new Parsedown();
        echo view('header',["intor" => $Parsedown->text("# 人物创建")]);

        echo view("webrote/roteform");
    }
}