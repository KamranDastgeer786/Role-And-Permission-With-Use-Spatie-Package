<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Fetch category and user for the product
       $category = Category::where('title', 'Sports & Fitness')->first();
       $user = User::first(); // You can adjust this to select a specific user if needed

       if (!$category || !$user) {
           $this->command->info('Category or user is missing. Please seed them first.');
           return;
       }

       // Single product data
       $product = [
           'name' => 'Yoga Mat',
           'description' => 'Non-slip surface, comfortable, easy to clean.',
           'quantity' => 5,
           'category_id' => $category->id,
           'user_id' => $user->id,
       ];

       // Insert product into the database
       Product::create($product);
    }
}
