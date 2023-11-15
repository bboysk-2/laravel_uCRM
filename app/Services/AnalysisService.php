<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class AnalysisService
{
    public static function perDay($subQuery) {

        $query =  $subQuery->where('status', true)
            ->groupBy('id')
            // DATE_FORMAT()で第一引数に指定したカラムのフォーマットを第二引数で設定。※対象のカラムが日付型 (DATEやDATETIMEなど) であることが必要
            ->selectRaw('SUM(subtotal) AS totalPerPurchase, DATE_FORMAT(created_at, "%Y/%m/%d") AS date')
            ->groupBy('date');

            // サブクエリを使用してデータベースから日別の集計データを取得
            $data = DB::table($query)
            ->groupBy('date')
            ->selectRaw('date, sum(totalPerPurchase) as total')
            ->get();

            // dateをキーとしてそれに紐づく値を抽出し、新たなコレクション型の変数に格納
            $labels = $data->pluck('date');
            $totals = $data->pluck('total');

            return [$data, $labels, $totals];
    }

    public static function perMonth($subQuery) {

        $query =  $subQuery->where('status', true)
            ->groupBy('id')
            // DATE_FORMAT()で第一引数に指定したカラムのフォーマットを第二引数で設定。※対象のカラムが日付型 (DATEやDATETIMEなど) であることが必要
            ->selectRaw('SUM(subtotal) AS totalPerPurchase, DATE_FORMAT(created_at, "%Y/%m") AS date')
            ->groupBy('date');

            // サブクエリを使用してデータベースから日別の集計データを取得
            $data = DB::table($query)
            ->groupBy('date')
            ->selectRaw('date, sum(totalPerPurchase) as total')
            ->get();

            // dateをキーとしてそれに紐づく値を抽出し、新たなコレクション型の変数に格納
            $labels = $data->pluck('date');
            $totals = $data->pluck('total');

            return [$data, $labels, $totals];
    }

    public static function perYear($subQuery) {

        $query =  $subQuery->where('status', true)
            ->groupBy('id')
            ->selectRaw('SUM(subtotal) AS totalPerPurchase, DATE_FORMAT(created_at, "%Y") AS date')
            ->groupBy('date');

            $data = DB::table($query)
            ->groupBy('date')
            ->selectRaw('date, sum(totalPerPurchase) as total')
            ->get();

            $labels = $data->pluck('date');
            $totals = $data->pluck('total');

            return [$data, $labels, $totals];
    }
}
