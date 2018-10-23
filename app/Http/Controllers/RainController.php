<?php

namespace App\Http\Controllers;

use App\Rain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RainController extends Controller
{
    public function index(Request $request)
    {
        $queryString = $request->query;
        if ($queryString->get('kindof') == 'month') {
            return Rain::select(['month', DB::raw('SUM(rain_rate)')])
                ->where('year', $queryString->get('year'))
                ->groupBy('month')
                ->get();
        }
        if ($queryString->get('kindof') == 'day') {
            return Rain::select(['day', 'rain_rate'])
                ->where('year', $queryString->get('year'))
                ->where('month', $queryString->get('month'))
                ->get();
        }
    }
}
