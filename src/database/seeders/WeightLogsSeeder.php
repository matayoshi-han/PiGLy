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
        $faker = Faker::create('ja_JP'); // 日本語ロケールでFakerを初期化
        $userId = 5; // 紐づけるユーザーID。環境に合わせて変更してください。

        // 過去20日間のデータを生成する例
        for ($i = 0; $i < 20; $i++) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $weight = $faker->randomFloat(1, 50, 80); // 50.0kgから80.0kgの間でランダム
            $calories = $faker->numberBetween(1200, 2500); // 1200calから2500calの間でランダム

            DB::table('weight_logs')->insert([
                'user_id' => $userId,
                'date' => $date,
                'weight' => $weight,
                'calories' => $calories,
                'exercise_time' => $faker->boolean(50) ? $faker->time('H:i') : null, // 50%の確率で時間を入力
                'exercise_content' => $faker->boolean(70) ? $faker->sentence(3) : null, // 70%の確率で運動内容を入力
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
