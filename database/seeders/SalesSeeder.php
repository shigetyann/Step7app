<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sale;
use App\Models\Sales;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    $sales = [
        [
            'product_id' => '1',
            'quantity' => '1',
        ]
    ];

    foreach ($sales as $sale) {
        Sales::firstOrCreate($sale);
    }
}

}
