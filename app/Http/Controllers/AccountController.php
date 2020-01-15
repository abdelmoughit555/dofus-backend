<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccoutRequest;
use App\Http\Resources\AccountResource;
use App\Models\Account;
use App\Scoping\Scopes\ClassScope;
use App\Scoping\Scopes\LevelScope;
use App\Scoping\Scopes\ServerScope;
use Illuminate\Http\Request;

class AccountController extends Controller
{

/*     public function __construct()
    {
        $this->middleware('auth:api');
    } */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account = Account::withScopes($this->scopes())->get();

        return  AccountResource::collection($account);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccoutRequest $request)
    {
        $account = Account::create($request->validated());

        return new AccountResource($account);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        return new AccountResource($account);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(AccoutRequest $request, Account $account)
    {
        $account->update($request->validated());

        return new AccountResource($account);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        $account->delete();
    }

    protected function scopes()
    {
        return [
            'level' => new LevelScope,
            'class' => new ClassScope,
            'server' => new ServerScope
        ];
    }
}
