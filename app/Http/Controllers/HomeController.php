<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeatureResource;
use App\Models\Feature;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(){
        $feature = Feature::where('active', true)->get();
        return Inertia::render('Welcome', [
            'features' => FeatureResource::collection($feature),
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }


}
