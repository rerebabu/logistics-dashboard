<?php

namespace App\Http\Controllers;

use App\Events\LocationUpdated;
use App\Models\ProximityLog;
use Illuminate\Http\Request;

class ProximityHistoryController extends Controller
{
    public function index()
    {
        $logs = ProximityLog::latest()->paginate(15);
        return view('proximity-history', compact('logs'));
    }

    public function updateLocation(Request $request)
    {
        $log = ProximityLog::create([
            'lat' => $request->lat,
            'lng' => $request->lng,
            'distance' => $request->distance,
            'within_range' => $request->within_range
        ]);

        event(new LocationUpdated($request->lat, $request->lng, $request->distance, $request->within_range));

        return response()->json($log);
    }
}
