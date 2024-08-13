<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountPaymentMethodRequest;
use App\Http\Resources\AccountPaymentMethodResource;
use App\Models\AccountPaymentMethod;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;


class AccountPaymentMethodController extends Controller
{
    /** Get account payment method list */
    public function index(): AnonymousResourceCollection
    {
        return AccountPaymentMethodResource::collection(AccountPaymentMethod::sort()->filter()->paginate(Request::get("per_page")));
    }

    /**
     * Store account payment method.
     */
    public function store(AccountPaymentMethodRequest $request): AccountPaymentMethodResource
    {
        return new AccountPaymentMethodResource(AccountPaymentMethod::create($request->validated()));
    }

    /**
     * Display the specified account payment method.
     */
    public function show(AccountPaymentMethod $accountPaymentMethod): AccountPaymentMethodResource
    {
        return new AccountPaymentMethodResource($accountPaymentMethod);
    }

    /**
     * Update account payment method.
     */
    public function update(AccountPaymentMethod $accountPaymentMethod, AccountPaymentMethodRequest $request): AccountPaymentMethodResource
    {
        $accountPaymentMethod->update($request->validated());
        return new AccountPaymentMethodResource($accountPaymentMethod);
    }

    /**
     * Remove the account payment method.
     */
    public function destroy(AccountPaymentMethod $accountPaymentMethod): Response
    {
        $accountPaymentMethod->delete();
        return response()->noContent();
    }
}
