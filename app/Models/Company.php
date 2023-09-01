<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


class Company extends Model
{
    public static function getList()
    {
        $companies = DB::table('companies')->get();
        return $companies;
    }

    public function Products()
    {
        return $this -> hasMany('App\Models\Product');
    }
}