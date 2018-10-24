<?php

namespace App\Http\Controllers;

use App\Accident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccidentController extends Controller
{
    public function index(Request $request)
    {
        $queryString = $request->query;
        if ($queryString->get('kindof') == 'month') {
            if ($queryString->get('district') == null) {
                return Accident::select(['district', DB::raw('COUNT(district) total')])
                    ->where('year', $queryString->get('year'))
                    ->groupBy('district')
                    ->get();
            }
            return Accident::select(['month', DB::raw('COUNT(*) total')])
                ->where('year', $queryString->get('year'))
                ->where('district', $queryString->get('district'))
                ->groupBy('month')
                ->get();
        }
        if ($queryString->get('kindof') == 'day') {
            if ($queryString->get('district') == null) {
                return Accident::select(['district', DB::raw('COUNT(district) total')])
                    ->where('year', $queryString->get('year'))
                    ->where('month', $queryString->get('month'))
                    ->groupBy('district')
                    ->get();
            }
            return Accident::select(['day', DB::raw('COUNT(*) total')])
                ->where('year', $queryString->get('year'))
                ->where('month', $queryString->get('month'))
                ->where('district', $queryString->get('district'))
                ->groupBy('day')
                ->get();
        }
    }
}
