<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bank::create([
            "bank_name" => "Monobank",
            "account_number" => "123 456 789",
            "logo" => "monobank.svg"
        ]);

        Bank::create([
            "bank_name" => "Privatbank",
            "account_number" => "987 654 321",
            "logo" => "privatbank.svg"
        ]);
    }
}
