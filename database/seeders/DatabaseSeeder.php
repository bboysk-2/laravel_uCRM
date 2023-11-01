<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Purchase;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ItemSeeder::class
        ]);

        \App\Models\Customer::factory(1000)->create();

        // 登録されているitem(サービス)全てを取得
        $items = \App\Models\Item::all();


        Purchase::factory(100)->create()
            ->each(function (Purchase $purchase) use ($items) {
                // purchaseテーブルに登録した際にitemsテーブルの情報に紐づけながら中間テーブルに情報を登録する
                $purchase->items()->attach(
                    // サービスを1~3件登録して配列化、quantity(数量)カラムに1~5の値を指定
                    $items->random(rand(1, 3))->pluck('id')->toArray(),
                    ['quantity' => rand(1, 5)]
                );
            });
    }
}
