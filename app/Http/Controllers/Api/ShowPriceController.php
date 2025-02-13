<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TokenPrice;
use App\Models\User;

class ShowPriceController
{
    private $id;
    private $tokenPrice;
    private $list;

    public function __construct()
    {
        $user = Auth::user();
        $this->id = $user->id ?? null;
        $this->tokenPrice = new TokenPrice;
        $this->list = $this->tokenPrice->getList();
    }

    private function userFavouriteTokens()
    {
        if (Auth::check()) {
            $userFavouriteTokens = User::find($this->id)->favourites()->orderBy('token_name', 'asc')->get()->pluck('token_name')->toArray();
        } else {
            $userFavouriteTokens = [];
        }
        return $userFavouriteTokens;
    }

    public function dropdownList()
    {
        $userFavouriteTokens = $this->userFavouriteTokens();
        $dropdownList = array_merge($userFavouriteTokens, array_filter($this->list, function ($value) use ($userFavouriteTokens) {
            return !in_array($value, $userFavouriteTokens);
        }));
        return $dropdownList;
    }

    public function showPrice(Request $request)
    {
        $tokenFrom = trim($request->input('dropdown_token_from'), ' *');
        $tokenTo = trim($request->input('dropdown_token_to'), ' *');

        $currencyPair = $this->tokenPrice->getCurrencyPair($tokenFrom, $tokenTo);

        $price = round($currencyPair["currency pair"]["data"]["amount"], 3);

        return response()->json([
            'price' => $price,
        ]);
    }

    public function updateFavourite(Request $request)
    {
        $userFavouriteTokens = $this->userFavouriteTokens();

        $tokenFrom = trim($request->input('dropdown_token_from'), ' *');
        $tokenTo = trim($request->input('dropdown_token_to'), ' *');
        $btnFavourite = $request->input('btn_favourite');

        $token = $btnFavourite === 'btn_from' ? $tokenFrom : $tokenTo;

        if (in_array($token, $userFavouriteTokens)) {
            User::find($this->id)->favourites()->where('token_name', $token)->delete();
            $updatedUserFavouriteTokens = User::find($this->id)->favourites()->orderBy('token_name', 'asc')->get()->pluck('token_name')->toArray();
        } else {
            User::find($this->id)->favourites()->updateOrInsert(
                ['token_name' => $token],
                ['user_id' => $this->id, 'token_name' => $token]
            );
            $updatedUserFavouriteTokens = User::find($this->id)->favourites()->orderBy('token_name', 'asc')->get()->pluck('token_name')->toArray();
        }
        $updatedUserDropdownList = $this->dropdownList();

        return response()->json([
            'userDropdownList' => $updatedUserDropdownList,
            'userFavouriteTokens' => $updatedUserFavouriteTokens
        ]);
    }
}
