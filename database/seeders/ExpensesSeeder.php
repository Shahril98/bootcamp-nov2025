<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ExpensesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('expenses')->insert([
            'user_id' => 1,
            'title' => 'Office Supplies',
            'description' => 'Purchased office supplies',
            'amount' => 15000,
            'category' => 'Office',
            'spent_at' => '2024-06-10',
            'notes' => 'Included pens, notebooks, and printer ink.',
        ]);
    }
}
