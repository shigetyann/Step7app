<?php

namespace App\Http\Controllers;


use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;





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
    public function getLists($keyword, $category, $priceMin = null, $priceMax = null, $stockMin = null, $stockMax = null)
    {
        $model = new Product();
        $products = $model->getList($keyword, $category, $priceMin, $priceMax, $stockMin, $stockMax);
        $comp = new Company();
        $companies = $comp->getList(); 
    
        return compact('products', 'keyword', 'category', 'companies', 'priceMin', 'priceMax', 'stockMin', 'stockMax');
    }
    
    public function search(Request $request)
    {
        $keyword = $request -> keyword;
        $category = $request  -> category;
        $priceMin = $request  -> priceMin;
        $priceMax = $request  -> priceMax;
        $stockMin = $request  -> stockMin;
        $stockMax = $request  -> stockMax;

        $data = $this->getLists($keyword, $category, $priceMin, $priceMax, $stockMin, $stockMax);

        return response()->json($data);
    }

    
    public function index(Request $request)
    {
        $keyword = $request -> keyword;
        $category = $request  -> category;
        $priceMin = $request  -> priceMin;
        $priceMax = $request  -> priceMax;
        $stockMin = $request  -> stockMin;
        $stockMax = $request  -> stockMax;

        $data = $this->getLists($keyword, $category, $priceMin, $priceMax, $stockMin, $stockMax);
    
        return view('index', $data);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        $comp = new Company();
        $companies = $comp->getList();
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
        $product = new Product;
        $product->create($request);
        return redirect()->route('products.index', $product);
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        $model = new Product();
        $model->renewal($request, $product);
        return redirect()->route('products.show', $product)
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
        DB::beginTransaction();

        try {
            $product->delete();
            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    
}
