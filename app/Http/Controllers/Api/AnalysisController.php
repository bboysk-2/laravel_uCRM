<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class AnalysisController extends Controller
{
    public function index(Request $request) {

        // OrderモデルのbetweenDateスコープを使用して、指定された期間のデータを取得するサブクエリを作成
        $subQuery = Order::betweenDate($request->startDate, $request->endDate);

        // タイプが'perDay'の場合の条件分岐
        if($request->type === 'perDay') {
            $subQuery->where('status', true)
            ->groupBy('id')
            // DATE_FORMAT()で第一引数に指定したカラムのフォーマットを第二引数で設定。※対象のカラムが日付型 (DATEやDATETIMEなど) であることが必要
            ->selectRaw('SUM(subtotal) AS totalPerPurchase, DATE_FORMAT(created_at, "%Y/%m/%d") AS date')
            ->groupBy('date');

            // サブクエリを使用してデータベースから日別の集計データを取得
            $data = DB::table($subQuery)
            ->groupBy('date')
            ->selectRaw('date, sum(totalPerPurchase) as total')
            ->get();

            $labels = $data->pluck('date');
            $totals = $data->pluck('total');
        }

       return response()->json([
        // キー名は任意で設定可能
          'data' => $data,
          'type' => $request->type,
          'labels' => $labels,
          'totals' => $totals
       ], Response::HTTP_OK);
    }
}
