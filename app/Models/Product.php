<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use CrudTrait;
    protected $fillable = [
        'zakeke_product_id',
        'name',
        'description',
        'price',
        'thumbnail',
        'customizable'
    ];

}
