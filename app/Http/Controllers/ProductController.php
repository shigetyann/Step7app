<?php

namespace App\Http\Controllers;


use App\Models\Company;
use App\Models\Product;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

use function Symfony\Component\String\b;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request -> keyword;
        $category = $request  -> category;
        
        $model = new Product();
        $products = $model -> getList($keyword, $category);
        $companies = Company::distinct()->select('company_name','id')->get();

        return view('index', compact('products', 'keyword', 'category', 'companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $companies = Company::distinct()->select('company_name','id')->get();
        return view('create',compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request -> validate([
            'product_name' => 'required|max:20',
            'price' => 'required|integer',
            'company_name' => 'required|string|exists:companies,company_name',
            'stock' => 'required|integer',
            'comment' => 'required|max:200',
            'img_path' => 'required|file|image',
        ]);

        $products = new Product;
        $products -> product_name = $request -> input(["product_name"]);
        $products -> price = $request -> input(["price"]);
        $products -> company_id = Company::where('company_name', $request -> input('company_name'))->first()->id;
        $products -> stock = $request -> input(["stock"]);
        $products -> comment = $request -> input(["comment"]);
        $file = $request -> file("img_path");
        $path = $file -> store('img','public');
        $products -> img_path = $path;
        $products -> save();

        return redirect() -> route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {

        $companies = Company::getList();
        return view('edit', compact('product', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator([
            'product_name' => 'required|max:20',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->save();

        return redirect() -> route('products.index')
            -> with('success', '商品情報を更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect() -> route('products.index');
    }
}
