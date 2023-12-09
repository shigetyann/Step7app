<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'company_id' => '1',
                'product_name' => 'コーラ',
                'price' => '120',
                'stock' => '100',
                'comment' => '世界で人気の炭酸飲料',
                'img_path' => 'img/cola.jpg',
            ],
            [
                'company_id' => '2',
                'product_name' => 'BOSS',
                'price' => '110',
                'stock' => '100',
                'comment' => '渋いおっさんが描かれたコーヒー',
                'img_path' => 'img/boss.jpg',
            ],
            [
                'company_id' => '3',
                'product_name' => '午後の紅茶',
                'price' => '160',
                'stock' => '40',
                'comment' => 'レモンティーが個人的に好き',
                'img_path' => 'img/gogothi.jpg',
            ],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate($product);
        }
    }
}
