<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Services\AnalysisService;

class AnalysisController extends Controller
{
    public function index(Request $request) {

        // OrderモデルのbetweenDateスコープを使用して、指定された期間のデータを取得するサブクエリを作成
        $subQuery = Order::betweenDate($request->startDate, $request->endDate);

        // タイプが'perDay'の場合の条件分岐
        if($request->type === 'perDay') {
            // 配列を受け取り変数に格納するため list() を使う
            list($data, $labels, $totals) = AnalysisService::perDay($subQuery);
        }

        if($request->type === 'perMonth') {
            // 配列を受け取り変数に格納するため list() を使う
            list($data, $labels, $totals) = AnalysisService::perMonth($subQuery);
        }

        if($request->type === 'perYear') {
            // 配列を受け取り変数に格納するため list() を使う
            list($data, $labels, $totals) = AnalysisService::perYear($subQuery);
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
