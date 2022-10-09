<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['brand','name','quantity','description','cost','price','stock','status','image'];

    public function carts()
    {
        return $this->belongsToMany('App\Models\Cart');
    }
}
