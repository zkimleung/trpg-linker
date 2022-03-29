<?php

namespace App\Controllers;
use Config;

use \App\Models\OccupationModel;


class Ocps extends BaseController
{
    use \CodeIgniter\API\ResponseTrait;

    public function lists(int $page = 1)
    {
        $data = [];
        $ocp_mod = new OccupationModel();
        $res = $ocp_mod->getOcuptions($page);
        foreach ($res as $doc){
            unset($doc["_id"]);
            $data[] = $doc;
        }
        return $this->respond([
            'occupation_list' => $data
        ],200);
    }
}