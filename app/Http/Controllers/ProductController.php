<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
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


    private function getCompanies()
    {
        $comp = new Company();
        return $comp->getList();
    }


    private function getRequestParameters(Request $request)
    {
        return [
            'keyword' => $request->keyword,
            'category' => $request->category,
            'priceMin' => $request->priceMin,
            'priceMax' => $request->priceMax,
            'stockMin' => $request->stockMin,
            'stockMax' => $request->stockMax,
        ];
    }


    public function getLists($parameters)
    {
        $model = new Product();
        $products = $model->getList(
            $parameters['keyword'], 
            $parameters['category'], 
            $parameters['priceMin'], 
            $parameters['priceMax'], 
            $parameters['stockMin'], 
            $parameters['stockMax']
        );
        $companies = $this->getCompanies(); 
        extract($parameters);

        return compact('products', 'companies', 'keyword', 'category', 'priceMin', 'priceMax', 'stockMin', 'stockMax');
    }


    public function search(Request $request)
    {
        $parameters = $this->getRequestParameters($request);
        $data = $this->getLists($parameters);
        return response()->json($data);
    }


    public function index(Request $request)
    {
        $parameters = $this->getRequestParameters($request);
        $data = $this->getLists($parameters);
        return view('index', $data);
    }


    public function create(Product $product)
    {
        $comp = new Company();
        $companies = $comp->getList();
        return view('create',compact('companies'));
    }


    public function store(Request $request)
    {
        $product = new Product;
        $product->create($request);
        return redirect()->route('products.index', $product);
    }


    public function show(Product $product)
    {
        return view('show', compact('product'));
    }


    public function edit(Product $product)
    {
        $companies = Company::getList();
        return view('edit', compact('product', 'companies'));
    }


    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        $model = new Product();
        $model->renewal($request, $product);
        return redirect()->route('products.show', $product)
            -> with('success', '商品情報を更新しました。');
    }


    public function destroy(Product $product)
    {
        DB::beginTransaction();

        try {
            $product->delete();
            DB::commit();
            Cache::flush();
            $productModel = new Product;
            $products = $productModel->getList();
            $table = view('products.table', compact('products'))->render();
            $pagination = view('products.pagination', compact('products'))->render();
        
            return response()->json(['success' => true, 'message' => '商品を削除しました。', 'table' => $table, 'pagination' => $pagination]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
