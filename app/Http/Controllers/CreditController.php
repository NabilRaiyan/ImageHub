<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeatureResource;
use App\Models\Feature;
use App\Models\Package;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    //

    public function index()
    {
        $package = Package::all();
        $feature = Feature::where('active', true)->get();

        return inertia("Credit/Index", [
            'package' => PackageResource::collection($package),
            'feature' => FeatureResource::collection($feature),
        ])

    }

    public function buyCredits(Package $package)
    {

    }

    public function success()
    {

    }

    public function cancel()
    {

    }

    public function webhook()
    {

    }
}
