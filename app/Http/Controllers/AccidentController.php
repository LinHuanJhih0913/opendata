<?php

namespace App\Http\Controllers;

use App\Accident;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccidentController extends Controller
{
    public function index(Request $request)
    {
        $queryString = $request->query;
        if ($queryString->get('kindof') == 'month') {
            if ($queryString->get('district') == null) {
                return response()->json([
                    'result' => 'success',
                    'kindof' => $queryString->get('kindof'),
                    'year' => $queryString->get('year'),
                    'month' => $queryString->get('month'),
                    'district' => $queryString->get('district'),
                    'items' => Accident::select(['district', DB::raw('COUNT(district) as total')])
                        ->where(DB::raw('YEAR(date)'), $queryString->get('year'))
                        ->groupBy('district')
                        ->get(),
                ], 200, [
                    'Access-Control-Allow-Origin' => '*',
                ]);
            }
            return response()->json([
                'result' => 'success',
                'kindof' => $queryString->get('kindof'),
                'year' => $queryString->get('year'),
                'month' => $queryString->get('month'),
                'district' => $queryString->get('district'),
                'items' => Accident::select([DB::raw('MONTH(date) as month, COUNT(*) as total')])
                    ->where(DB::raw('YEAR(date)'), $queryString->get('year'))
                    ->where('district', $queryString->get('district'))
                    ->groupBy(DB::raw('MONTH(date)'))
                    ->get(),
            ], 200, [
                'Access-Control-Allow-Origin' => '*',
            ]);
        }
        if ($queryString->get('kindof') == 'day') {
            if ($queryString->get('district') == null) {
                return response()->json([
                    'result' => 'success',
                    'kindof' => $queryString->get('kindof'),
                    'year' => $queryString->get('year'),
                    'month' => $queryString->get('month'),
                    'district' => $queryString->get('district'),
                    'items' => Accident::select(['district', DB::raw('COUNT(district) as total')])
                        ->where(DB::raw('YEAR(date)'), $queryString->get('year'))
                        ->where(DB::raw('MONTH(date)'), $queryString->get('month'))
                        ->groupBy('district')
                        ->get(),
                ], 200, [
                    'Access-Control-Allow-Origin' => '*',
                ]);
            }
            $result = [];
            $data = Accident::select([DB::raw('DAY(date) as day, COUNT(*) as total')])
                ->where(DB::raw('YEAR(date)'), $queryString->get('year'))
                ->where(DB::raw('MONTH(date)'), $queryString->get('month'))
                ->where('district', $queryString->get('district'))
                ->groupBy(DB::raw('DAY(date)'))
                ->get();

            $dayInmonth = new Carbon("{$queryString->get('year')}-{$queryString->get('month')}");
            for ($i = 0; $i < $dayInmonth->daysInMonth; $i++) {
                array_push($result, ['day' => $i + 1, 'total' => 0]);
            }
            for ($i = 0; $i < sizeof($data); $i++) {
                $result[$data[$i]['day'] - 1] = $data[$i];
            }
            return response()->json([
                'result' => 'success',
                'kindof' => $queryString->get('kindof'),
                'year' => $queryString->get('year'),
                'month' => $queryString->get('month'),
                'district' => $queryString->get('district'),
                'items' => $result,
            ], 200, [
                'Access-Control-Allow-Origin' => '*',
            ]);
        }
    }

    public function detail(Request $request)
    {
        $accident = Accident::query();
        if ($request->route('year') != null) {
            $accident->where(DB::raw('YEAR(date)'), $request->route('year'));
        }
        if ($request->route('month') != null) {
            $accident->where(DB::raw('MONTH(date)'), $request->route('month'));
        }
        if ($request->route('district') != null) {
            $accident->where('district', $request->route('district'));
        } else {
            $accident->addSelect('district');
        }
        return response()->json([
            'year' => $request->route('year'),
            'month' => $request->route('month'),
            'district' => $request->route('district'),
            'items' => $accident->addSelect(['gps_longitude', 'gps_latitude'])->get()
        ], 200, [
            'Access-Control-Allow-Origin' => '*',
        ]);
    }

    public function sdg(Request $request)
    {
        $accident = Accident::query();
        if ($request->route('district') != null) {
            $accident->where('district', $request->route('district'));
        }
        $accident->addSelect([DB::raw('YEAR(date) year'), DB::raw('COUNT(city) total')]);
        $accident->groupBy([DB::raw('YEAR(date)')]);
        return response()->json([
            'district' => $request->route('district'),
            'items' => $accident->get(),
        ], 200, [
            'Access-Control-Allow-Origin' => '*',
        ]);
    }
}
