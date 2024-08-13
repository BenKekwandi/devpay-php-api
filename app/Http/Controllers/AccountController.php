<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Models\Account;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request;
use App\Http\Resources\AccountResource;

class AccountController extends Controller
{

    /** Get account list */
    public function index() : AnonymousResourceCollection
    {
        return AccountResource::collection(Account::sort()->filter()->paginate(Request::get("per_page")));
    }

    /** Store account */
    public function store(AccountRequest $request) : AccountResource
    {
        return new AccountResource(Account::create($request->validated()));
    }

    /**
     * Display the specified account.
     */
    public function show(Account $account) : AccountResource
    {
        return AccountResource::make($account);
    }

    /**
     * Update the account.
     */
    public function update(Account $account, AccountRequest $request) : AccountResource
    {
        $account->update($request->validated());

        return new AccountResource($account);
    }

    /**
     * Remove the account.
     */
    public function destroy(Account $account) : Response
    {
        $account->delete();
        return response()->noContent();
    }
}