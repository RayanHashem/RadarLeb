<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use Illuminate\Http\Request;

class RadarController extends Controller
{
    public function status()
    {
        return response()->json([
            'online' => (bool) SystemSetting::get('scans_enabled', true),
        ]);
    }
}
