<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Product 1',
                'price' => 100.00,
            ],
            [
                'name' => 'Product 2',
                'price' => 200.00,
            ],
            [
                'name' => 'Product 3',
                'price' => 150.00,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
