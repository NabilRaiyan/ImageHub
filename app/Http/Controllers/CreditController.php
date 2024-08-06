<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeatureResource;
use App\Http\Resources\PackageResource;
use App\Models\Feature;
use App\Models\Package;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\StripeClient;



use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

class CreditController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        $features = Feature::where('active', true)->get();

        return inertia("Credit/Index", [
            'packages' => PackageResource::collection($packages),
            'features' => FeatureResource::collection($features),
            'success' => session('success'),
            'error' => session('error'),
        ]);

    }

    public function buyCredits(Package $package)
    {
        $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $package->name . '_' . $package->credits . ' credits',
                    ],
                    'unit_amount' => $package->price * 100,
                ],
                'quantity' => 1,
            ]],
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

    public function webhook(Request $request)
    {
        // This is a stripe CLI webhook secret for testing your endpoint locally
        $endpoint_secret = env('STRIPE_WEBHOOK_KEY');

        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $event = null;

        if (!$sig_header) {
            Log::error('Stripe signature header missing');
            return response('', 400);
        }

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            Log::error('Invalid payload', ['exception' => $e]);
            return response('', 400);
        } catch (SignatureVerificationException $e) {
            Log::error('Invalid signature', ['exception' => $e]);
            return response('', 400);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $transaction = Transaction::where('session_id', $session->id)->first();
                if ($transaction && $transaction->status === 'pending') {
                    $transaction->status = 'paid';
                    $transaction->save();

                    $transaction->user->available_credits += $transaction->credits;
                    $transaction->user->save(); // Don't forget to save the user changes
                }
                break;

            default:
                Log::warning('Received unknown event type', ['type' => $event->type]);
                return response('Received unknown event type', 400);
        }

        return response('Webhook handled', 200);
    }
}
