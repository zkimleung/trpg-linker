<?php namespace App\Entities;

use CodeIgniter\Entity;

class RoteEnt extends Entity
{
    protected $attributes = [
        'attribute' => null,
        'skill' => null,
        'assets' => null,
        'profile' => null
    ];

    protected $datamap = [
        'id' => '_id'
    ];

    protected $casts = [
        'attribute' => 'json',
        'assets' => 'json',
        'skill' => 'json',
        'profile' => 'json'
    ];

}