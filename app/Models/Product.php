<?php

namespace App\Models;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;


class Product extends Model
{
    protected $fillable = [
        'product_name',
        'price',
        'stock',
        'company_id',
        'company_name',
        'comment',
        'img_path',
    ];

    public function getimageUrlAttribute()
    {return asset('storage/'.$this -> img_path);}

    public static function product()
    {
        $product = DB::table('products')
        -> join('companies', 'products.company_id', '=', 'companies.id') 
        -> select('products.*','companies.company_name')
        -> orderBy('id');
        return $product;
    }

    public function getList($keyword = null, $category = null, $priceMin = null, $priceMax = null, $stockMin = null, $stockMax = null) 
    {
        $model = Product::query();
        if($keyword)
        {$model -> where('product_name', 'like', "%{$keyword}%");}

        if($category)
        {
            $company = Company::where('company_name', $category)->first();
            if($company) {
                $model -> where('company_id', $company->id);
            }
        }
        
        if($priceMin)
        {$model -> where('price', '>=', $priceMin);}

        if($priceMax)
        {$model -> where('price', '<=', $priceMax);}

        if($stockMin)
        {$model -> where('stock', '>=', $stockMin);}

        if($stockMax)
        {$model -> where('stock', '<=', $stockMax);}

        return $model;
    }


    public function create(Request $request)
    {
        DB::beginTransaction();

        try{
            $validator = Validator::make($request->all(), [
                'product_name' => 'required|max:20',
                'price' => 'required|integer',
                'company_name' => 'required|string|exists:companies,company_name',
                'stock' => 'required|integer',
                'comment' => 'required|max:200',
                'img_path' => 'required|file|image',
            ]);

            if ($validator->fails()) {
                throw new \Illuminate\Validation\ValidationException($validator);
            }

            $products = new Product;
            $products->product_name = $request->input(["product_name"]);
            $products->price = $request->input(["price"]);
            $products->stock = $request->input(["stock"]);
            $products->comment = $request->input(["comment"]);
            $products->company_id = Company::where('company_name',
                $request->input('company_name'))->first()->id;

            $file = $request->file("img_path");
            $path = $file->store('img','public');
            $products->img_path = $path;
            $products->save();
            DB::commit();
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return back()->withInput()->withErrors($e->validator->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function renewal(Request $request, Product $product)
    {
        DB::beginTransaction();
        try{
            $request->validate([
                'product_name' => 'required|max:20',
                'price' => 'required|integer',
                'stock' => 'required|integer',
                'comment' => 'required|max:200',
                'img_path' => 'nullable|file|image',
            ]);

            $product->product_name = $request->input(["product_name"]);
            $product->price = $request->input(["price"]);
            $product->stock = $request->input(["stock"]);
            $product->comment = $request->input(["comment"]);
            $product->company_id = $request->input('company_id');

            if($request->hasFile('img_path')){
                $file = $request->file("img_path");
                $path = $file->store('img','public');
                $product->img_path = $path;
            }
            
            $product->save();
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function sales()
    {
        return $this->hasMany('App\Models\Sales');
    }
}
