<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table="shopping_cart";

    protected $fillable=['product_id','quantity','unit_price','subtotal'];
}
