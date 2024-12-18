<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Plumbing', 
                'description' => 'Services related to plumbing.', 
                'status' => 1,
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'Electrical', 
                'description' => 'Services related to electrical work.', 
                'status' => 1,
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'Carpentry', 
                'description' => 'Woodwork and carpentry services.', 
                'status' => 1,
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'name' => 'Painting', 
                'description' => 'House and commercial painting.', 
                'status' => 1,
                'created_at' => now(), 
                'updated_at' => now()
            ],
        ];
        
        DB::table('categories')->insert($categories);        
    }
}
