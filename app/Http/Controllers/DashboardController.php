<?php

namespace App\Http\Controllers;

use App\Http\Resources\UsedFeatureResource;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(){
        $usedFeatures = UsedFeatureResource::query()
            ->with(['feature'])
            ->where("used_id", auth()->user()->id)
            ->latest()
            ->paginate();

            return Inertia::render('Dashboard', [
                'usedFeatures' => UsedFeatureResource::collection($usedFeatures), 
            ]);
    }
}
