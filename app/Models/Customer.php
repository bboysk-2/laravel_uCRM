<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Purchase;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'kana',
        'tel', 'email',
        'postcode',
        'address',
        'birthday',
        'gender',
        'memo'
    ];

    //$input = null...$inputが渡されなかった場合に、$inputの値がnullであることを意味する(デフォルト引数)
    public function scopeSearchCustomer($query, $input = null)
    {
        // 検索ワードが入力されている場合前方一致検索
        if (!empty($input)) {
            if (Customer::where('kana', 'like', $input . '%')
                ->orWhere('tel', 'like', $input . '%')->exists()
            ) {
                // 検索にヒットするデータがある場合データ取得
                return $query->where('kana', 'like', $input . '%')
                    ->orWhere('tel', 'like', $input . '%');
            }
        }
    }

    public function purchase()
    {
        // 1つのモデルに対して複数のPurchaseモデルのレコードが存在することを示す
        return $this->hasMany(Purchase::class);
    }
}
