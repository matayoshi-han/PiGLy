<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Carbon\Carbon;

class WeightLogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ja_JP');
        $userId = 1;

        for ($i = 0; $i < 20; $i++) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $weight = $faker->randomFloat(1, 50, 80);
            $calories = $faker->numberBetween(1200, 2500);

            DB::table('weight_logs')->insert([
                'user_id' => $userId,
                'date' => $date,
                'weight' => $weight,
                'calories' => $calories,
                'exercise_time' => $faker->boolean(50) ? $faker->time('H:i') : null,
                'exercise_content' => $faker->boolean(70) ? $faker->sentence(3) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
