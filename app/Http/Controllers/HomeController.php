<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        //商品一覧をページネートで取得
        $products = Product::latest()->paginate(5);

        //検索フォームで入力された値を取得する
        $search = $request -> input('search');

        //クエリビルダ
        $query = Product::query();

        //もし検索フォームにキーワードが入力されたら
        if($search){
            //全角スペースを半角に変換
            $spaceConversion = mb_convert_kana($search,'s');

            //単語をループで回し、部分一致するものがあれば、$queryとして保持
            foreach($search as $value){
                $query -> where('id','product_name','%'.$value.'%');
            }

            //上記で取得した$queryをページネートにし、変数$productsを代入
            $products = $query -> paginate(5);
        }
        //viewにpuroductsとsearchを変数として渡す
        return view('home',compact('products'))
            ->with([
                'puroducts' => $products,
                'search' => $search,
            ]);
        
            return view('home',compact('products'))
            ->with('i',(request() -> input('page',1)-1)*5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
