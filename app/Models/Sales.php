<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $fillable = ['product_id', 'quantity'];

    public function getList()
    {
        $sales = DB::table('sales')->get();
        return $sales;
    }

    public function product()
    {
        return $this -> belongsTo('App\Models\Product');
    }
}
