<?php namespace App\Entities;

use CodeIgniter\Entity;

class RoteEnt extends Entity
{
    protected $attributes = [
        'attribute' => null,
        'skill' => null,
        'profile' => null
    ];

    protected $datamap = [
        'id' => '_id'
    ];

    protected $casts = [
        'attribute' => 'json',
        'skill' => 'json',
        'profile' => 'json'
    ];

    public function getEntsData(){
        $data = [
            'attribute' => $this->attribute,
            'skill' => $this->skill,
            'profile' => $this->profile,
            'update_at' => $this->update_at,
            'create_at' => $this->create_at,
            'delete_at' => $this->delete_at,
        ];
        return $data;
    }

}