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
            // SELECT month, COUNT(*) FROM accidents WHERE year = 2018 AND district = '東區' GROUP BY month
            return Accident::select(['month', DB::raw('COUNT(*)')])
                ->where('year', $queryString->get('year'))
                ->where('district', $queryString->get('district'))
                ->groupBy('month')
                ->get();
        }
        if ($queryString->get('kindof') == 'day') {
            // SELECT day, COUNT(*) FROM accidents WHERE year = 2018 AND month = 1 AND district = '東區' GROUP BY day
            return Accident::select(['day', DB::raw('COUNT(*)')])
                ->where('year', $queryString->get('year'))
                ->where('month', $queryString->get('month'))
                ->where('district', $queryString->get('district'))
                ->groupBy('day')
                ->get();
        }
    }
}
