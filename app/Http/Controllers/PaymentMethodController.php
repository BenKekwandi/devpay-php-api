<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentMethodRequest;
use App\Models\PaymentMethod;
use App\Http\Resources\PaymentMethodResource;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class PaymentMethodController extends Controller
{
    /** Get payment method list */
    public function index(): AnonymousResourceCollection
    {
        return PaymentMethodResource::collection(PaymentMethod::sort()->filter()->paginate(Request::get("per_page")));
    }

    /**
     * Store payment method.
     */
    public function store(PaymentMethodRequest $request): PaymentMethodResource
    {
        return new PaymentMethodResource(PaymentMethod::create($request->validated()));
    }

    /**
     * Display the specified payment method.
     */
    public function show(PaymentMethod $paymentMethod): PaymentMethodResource
    {
        return new PaymentMethodResource($paymentMethod);
    }

    /**
     * Update payment method.
     */
    public function update(PaymentMethod $paymentMethod, PaymentMethodRequest $request): PaymentMethodResource
    {
        $paymentMethod->update($request->validated());
        return new PaymentMethodResource($paymentMethod);
    }

    /**
     * Remove the payment method.
     */
    public function destroy(PaymentMethod $paymentMethod): Response
    {
        $paymentMethod->delete();
        return response()->noContent();
    }
}
