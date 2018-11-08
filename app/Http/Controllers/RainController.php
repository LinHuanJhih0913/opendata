<?php

namespace App\Http\Controllers;


use App\Rainfall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RainController extends Controller
{
    public function index(Request $request)
    {
        $queryString = $request->query;
        if ($queryString->get('kindof') == 'month') {
            return response()->json([
                'result' => 'success',
                'kindof' => $queryString->get('kindof'),
                'year' => $queryString->get('year'),
                'month' => $queryString->get('month'),
                'items' => Rainfall::select([DB::raw('MONTH(date) as month, SUM(rainfall) as rain_rate')])
                    ->where(DB::raw('YEAR(date)'), $queryString->get('year'))
                    ->groupBy(DB::raw('MONTH(date)'))
                    ->get(),
            ], 200, [
                'Access-Control-Allow-Origin' => '*',
            ]);
        }
        if ($queryString->get('kindof') == 'day') {
            return response()->json([
                'result' => 'success',
                'kindof' => $queryString->get('kindof'),
                'year' => $queryString->get('year'),
                'month' => $queryString->get('month'),
                'items' => Rainfall::select([DB::raw('day(date) as day, rainfall as rain_rate')])
                    ->where(DB::raw('YEAR(date)'), $queryString->get('year'))
                    ->where(DB::raw('MONTH(date)'), $queryString->get('month'))
                    ->get(),
            ], 200, [
                'Access-Control-Allow-Origin' => '*',
            ]);
        }
    }
}
