<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accountTypes = [
            // Wallets
            [
                'name' => 'Jazzcash',
                'description' => 'Digital wallet for convenient mobile payments.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Easypaisa',
                'description' => 'Digital wallet by Telenor Microfinance Bank.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'SadaPay',
                'description' => 'Modern digital wallet in Pakistan.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nayapay',
                'description' => 'Pakistan’s first EMoney wallet and card.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Banks
            [
                'name' => 'Meezan Bank',
                'description' => 'Pakistan’s leading Islamic bank.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'HBL',
                'description' => 'Habib Bank Limited - largest bank in Pakistan.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'UBL',
                'description' => 'United Bank Limited.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Allied Bank',
                'description' => 'A major bank in Pakistan.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'MCB Bank',
                'description' => 'Muslim Commercial Bank.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bank Alfalah',
                'description' => 'Private bank with a strong presence.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Standard Chartered Bank',
                'description' => 'International bank operating in Pakistan.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Faysal Bank',
                'description' => 'Transitioning to full Islamic banking.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Askari Bank',
                'description' => 'Bank owned by the Fauji Foundation.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'National Bank of Pakistan',
                'description' => 'Government-owned bank.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bank of Punjab',
                'description' => 'Provincial government-owned bank.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bank Islami',
                'description' => 'Dedicated Islamic bank.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'JS Bank',
                'description' => 'A leading private bank.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Soneri Bank',
                'description' => 'Private bank focusing on SMEs.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Samba Bank',
                'description' => 'Saudi-owned bank operating in Pakistan.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('account_types')->insert($accountTypes);
    }
}
