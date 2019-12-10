<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
            'name', 'description', 'image', 'category', 'price'
        ];

        public function getPriceAttribute($a){
            $newForm = $a."€";
            return $newForm;
        }
}
