<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = Plan::all();

        if (count($plans)) {
            return;
        }

        DB::table('plans')->insert([
            [
                "id"          =>  1,
                "title"       => "FreeTest",
                "description" => "free-test",
                "price"       =>  0,
                "limit"       =>  2,
                "interval"    =>  300,
                "duration"    =>  31,
                "active"      =>  1,
            ],
            [
                "id"          =>  2,
                "title"       => "Mini",
                "description" => "mini",
                "price"       =>  1,
                "limit"       =>  5,
                "interval"    =>  60,
                "duration"    =>  31,
                "active"      =>  1,
            ],
            [
                "id"          =>  3,
                "title"       => "Standart",
                "description" => "standart",
                "price"       =>  2,
                "limit"       =>  10,
                "interval"    =>  60,
                "duration"    =>  31,
                "active"      =>  1,
            ],
        ]);

    }
}
