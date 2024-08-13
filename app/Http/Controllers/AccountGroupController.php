<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountGroupRequest;
use App\Http\Resources\AccountGroupResource;
use App\Models\AccountGroup;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request;

class AccountGroupController extends Controller
{

    /** Get account group list */
    public function index() : AnonymousResourceCollection
    {
        return AccountGroupResource::collection(AccountGroup::sort()->filter()->paginate(Request::get("per_page")));
    }

    /** Store account group */
    public function store(AccountGroupRequest $request) : AccountGroupResource
    {
        return new AccountGroupResource(AccountGroup::create($request->validated()));
    }

    /**
     * Display the specified account group.
     */
    public function show(AccountGroup $accountGroup) : AccountGroupResource
    {
        return AccountGroupResource::make($accountGroup);
    }

    /**
     * Update the account group.
     */
    public function update(AccountGroup $accountGroup, AccountGroupRequest $request) : AccountGroupResource
    {
        $accountGroup->update($request->validated());

        return new AccountGroupResource($accountGroup);
    }

    /**
     * Remove the account group.
     */
    public function destroy(AccountGroup $accountGroup) : Response
    {
        $accountGroup->delete();

        return response()->noContent();
    }
}