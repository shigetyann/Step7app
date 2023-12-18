<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SalesController extends Controller
{
    public function purchase(Request $request)
    {
        DB::beginTransaction();

        try{
            $productID = $request->input('product_id');
            $quantity = $request->input('quantity', 1);

            $product = Product::lockForUpdate()->find($productID);

            if(!$product){
                return response()->json(['message' => '商品が存在しません'], 404);
            }
            if($product->stock <= 0){
                return response()->json(['message' => '在庫がありません'], 400);
            }
            if($product->stock < $quantity){
                return response()->json(['message' => '在庫数以上は購入できません'], 400);
            }
            
            $product->stock -= $quantity;
            $product->save();

            $sale = new Sales([
                'product_id' => $productID,
                'quantity' => $quantity,
            ]);
            $sale->save();
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' =>  '購入処理に失敗しました：' . $e->getMessage()],500);
        }
        return response()->json(['message' => 'お買い上げありがとうございます。', 'new_stock' => $product->stock]);
    }
}
