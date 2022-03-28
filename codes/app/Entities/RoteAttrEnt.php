<?php namespace App\Entities;

use CodeIgniter\Entity;

class RoteAttrEnt extends Entity
{
    protected $attributes = [
        "STR"=>0, //力量
        "DEX"=>0, //敏捷
        "INT"=>0, //智力
        "CON"=>0, //体质
        "POW"=>0, //意志
        "APP"=>0, //外貌
        "SIZ"=>0, //体型
        "EDU"=>0, //教育
        "Luck"=>0,//幸运
        "MOV"=>0, //移动
        "HP" => null,//血量
        "MP" => null,//魔法
        "Sanity" => null//理智
    ];

    protected $casts = [
        "STR"=>'integer', //力量
        "DEX"=>'integer', //敏捷
        "INT"=>'integer', //智力
        "CON"=>'integer', //体质
        "POW"=>'integer', //意志
        "APP"=>'integer', //外貌
        "SIZ"=>'integer', //体型
        "EDU"=>'integer', //教育
        "Luck"=>'integer',//幸运
        "MOV"=>'integer', //移动
        "HP" => 'integer',//血量
        "MP" => 'integer',//魔法
        "Sanity" => 'integer'//理智
    ];

    public function getAttrDetails(string $attr = '', int $ext = 0){
        switch ($attr) {
            case 'HP':
                $org = (int) (($this->CON + $this->SIZ)/10);
                break;

            case 'MP':
                $org = (int) ($this->POW / 5);
                break;
            
            case 'Sanity':
                $org = (int) ($this->POW + $ext);
                break;

            case 'MOV':
                if ($this->DEX > $this->SIZ && $this->STR > $this->SIZ){
                    $org = 9;
                } elseif ($this->DEX < $this->SIZ && $this->STR < $this->SIZ){
                    $org = 7;
                } else {
                    $org = 8;
                }
                break;

            default:
                $org = $this->$attr;
                return [
                    "origin" => $org,
                    "difficulty" => (int) ($org/2),
                    "extremely" => (int) ($org/5)
                ];
                break;
        }
        $this->$attr = $org;
        return [
            "origin" => $org,
            "current" => (isset($this->$attr))?$this->$attr:$org
        ];
    }

    public function getRuleAge(int $age = 18, int $edu_roll = 0, int $luky = 0, int $luky2 = 0){
        $return = [];
        switch ($age) {
            case $age < 20:
                $this->EDU -= 5;
                if ($luky2 > $luky) {
                    $this->Luck = $luky2;
                }
                $return['STR&SIZ'] = '-5';
                break;
                
            case $age < 40:
                if ($edu_roll > $this->EDU){
                    $return['EDU'] = "+1D10";
                }
                break;

            case $age < 50:
                $return['STR&CON&DEX'] = '-5';
                if (($edu_roll*2) > $this->EDU){
                    $return['EDU'] = "+1D10";
                }
                $this->APP -= 5;
                break;

            case $age < 60:
                $this->APP -= 10;
                $return['STR&CON&DEX'] = '-10';
                if (($edu_roll*3) > $this->EDU){
                    $return['EDU'] = "+1D10";
                }
                break;
            
            default:
                $this->APP -= 15;
                if (($edu_roll*4) > $this->EDU){
                    $return['EDU'] = "+1D10";
                }
                $return['STR&CON&DEX'] = '-20';
                break;
        }
        return $return;
    }
}