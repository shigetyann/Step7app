<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('companies')->insert([
            [
                'company_name' => 'コカコーラ',
                'street_address' => '大阪府大阪市4丁目1-2',
                'representative_name' => '佐藤',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],
            [
                'company_name' => 'サントリー',
                'street_address' => '京都府京都市3丁目1-2',
                'representative_name' => '鈴木',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],
            [
                'company_name' => 'キリン',
                'street_address' => '滋賀県彦根市1丁目1-2',
                'representative_name' => 'ひこにゃん',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ]
        ]);
    }
}
