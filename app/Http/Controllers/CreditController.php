<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeatureResource;
use App\Http\Resources\PackageResource;
use App\Models\Feature;
use App\Models\Package;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'success' => session('success'),
            'error' => session('error'),
        ]);

    }

    public function buyCredits(Package $package)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $package->name . '_' . $package->credits . ' credits',
                    ],
                    'unit_amount' => $package->price * 100,
                ], 
                'quantity' => 1,
            ],
            'mode' => 'payment',
            'success_url' => route('credit.success', [], true),
            'cancel_url' => route('credit.cancel', [], true),
        ]);

        Transaction::create([
            'status' => 'pending',
            'price' => $package->price,
            'credits' => $package->credits,
            'session_id' => $checkout_session->id,
            'user_id' => Auth::id(),
            'package_id' => $package->id,
        ]);
        return redirect($checkout_session->url);

    }

    public function success()
    {
        return to_route('credit.index')->with('success', 'You have successfully bought new credits.');
    }

    public function cancel()
    {
        return to_route('credit.index')->with('error', 'There was an error in payment process. Please try again.');

    }

    public function webhook()
    {

    }
}
