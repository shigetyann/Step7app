<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company; 

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = [
            [
                'company_name' => 'コカコーラ',
                'street_address' => '大阪府大阪市4丁目1-2',
                'representative_name' => '佐藤',
            ],
            [
                'company_name' => 'サントリー',
                'street_address' => '京都府京都市3丁目1-2',
                'representative_name' => '鈴木',
            ],
            [
                'company_name' => 'キリン',
                'street_address' => '滋賀県彦根市1丁目1-2',
                'representative_name' => 'ひこにゃん',
            ]
        ];

        foreach ($companies as $company) {
            Company::firstOrCreate($company);
        }
    }
}
