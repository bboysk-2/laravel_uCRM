<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // 過去十年分
        $decade = $this->faker->dateTimeThisDecade;
        // 未来2年分(過去8年分～未来2年分)
        $created_at = $decade->modify('+2 years');

        return [
            // 1~Customerテーブルのidの数分のランダム値をcustomer_idとして扱う
            'customer_id' => rand(1, Customer::count()),
            // 販売中かどうか
            'status' => $this->faker->boolean,
            // 購入日
            'created_at' => $created_at
        ];
    }
}
