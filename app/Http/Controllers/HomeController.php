<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\TokenPrice;
use App\Models\User;

class HomeController
{
    private $id;
    private $email;
    private $tokenPrice;

    public function __construct()
    {
        $user = Auth::user();
        $this->tokenPrice = new TokenPrice;
        $this->id = $user->id ?? null;
        $this->email = $user->email ?? null;
    }

    public function index(): View
    {
        $isAuthenticated = Auth::check();
        $list = $this->tokenPrice->getList();
        if ($isAuthenticated) {
            $userFavouriteTokens = User::find($this->id)->favourites()->orderBy('token_name', 'asc')->get()->pluck('token_name')->toArray();
        } else {
            $userFavouriteTokens = [];
        }
        $dropdownList = array_merge($userFavouriteTokens, array_filter($list, function ($value) use ($userFavouriteTokens) {
            return !in_array($value, $userFavouriteTokens);
        }));

        return view('index')
            ->with('email', $this->email)
            ->with('pageTitle', 'Currency Token Price')
            ->with('userFavouriteTokens', $userFavouriteTokens)
            ->with('dropdownList', $dropdownList)
            ->with('isAuthenticated', $isAuthenticated);
    }
}
