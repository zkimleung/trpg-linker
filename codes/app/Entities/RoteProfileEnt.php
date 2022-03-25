<?php namespace App\Entities;

use CodeIgniter\Entity;

class RoteProfileEnt extends Entity
{
    protected $attributes = [
        "name"=>"",
        "sex"=>"",
        "pc"=>"",
        "born_age"=>0,
        "occupation"=>0,
        "age"=>0,
        "hometown" => "",
        "residence" => "",
        "idiosyncrasy"=>[]
    ];

    protected $casts = [
        'idiosyncrasy' => 'json'
    ];

    public function sycIndyList(){
        return [
            "desc"=>[
                "desc" => "",
                "is_mark" => false
            ],
            "miss"=>[
                "desc" => "",
                "is_mark" => false
            ],
            "important"=>[
                "desc" => "",
                "is_mark" => false
            ],
            "promised_land"=>[
                "desc" => "",
                "is_mark" => false
            ],
            "precious"=>[
                "desc" => "",
                "is_mark" => false
            ],
            "character"=>[
                "desc" => "",
                "is_mark" => false
            ],
            "scar"=>"",
            "disease"=>""
        ];
    }

}