<?php

namespace App\Http\Controllers;

use App\Models\ProximityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProximityAlertController extends Controller
{
    public function checkProximity(Request $request) {
        // Validate input
        $validated = $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'radius' => 'required|in:100,250,500'
        ]);

        $response = Http::post('https://proximity-alert.onrender.com/check_proximity', [
            'warehouse' => [14.5995, 120.9842],
            'delivery' => [(float) $validated['lat'], (float) $validated['lng']],
            'radius' => (float) $validated['radius']
        ]);

        if ($response->failed()) {
            return back()->withErrors(['api' => 'API request failed (Status: '.$response->status().')']);
        }

        $data = $response->json();
        if (!$data || !isset($data['distance'], $data['within_range'])) {
            return back()->withErrors(['api' => 'Invalid API response']);
        }

        // Save log to database
        ProximityLog::create([
            'lat' => $validated['lat'],
            'lng' => $validated['lng'],
            'radius' => $validated['radius'],
            'distance' => $data['distance'],
            'within_range' => $data['within_range']
        ]);

        return view('dashboard.alerts', ['data' => $data]);
    }

}
