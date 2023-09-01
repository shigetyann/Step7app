<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;



class Product extends Model
{
    protected $fillable = [
        'product_name',
        'price',
        'stock',
        'company_id',
        'comment',
        'img_path',
    ];

    public function getimageUrlAttribute()
    {
        return asset('storage/'.$this -> img_path);
    }

    public static function product()
    {
        $product = DB::table('products')
        -> join('companies', 'products.company_id', '=', 'companies.id') 
        -> select('products.*','companies.company_name')
        -> orderBy('id');
        return $product;
    }

    public function getList($keyword, $category) 
    { 
        $model = $this->product();
        if($keyword)
        {
            $model -> where('product_name', 'like', "%{$keyword}%");
        }
        
        if($category)
        {
            $model -> where('company_name', 'like', "%{$category}%");
        }
        
        return $model->paginate(5)->appends(['keyword' => $keyword, 'category' => $category]);
    }

    public function company()
    {
        return $this -> belongsTo('App\Models\Company');
    }

    public function sales()
    {
        return $this -> hasMany('App\Models\Sales');
    }
}
