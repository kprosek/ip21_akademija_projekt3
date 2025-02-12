<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class TokenFavouriteHttpTest extends TestCase
{
    public function test_like_token_functionality(): void
    {
        $user = User::where('id', 0)->first();
        $testToken = 'BADGER';

        $response = $this->actingAs($user);

        $response = $this->post('/show-price', [
            'dropdown_token_from' => $testToken,
            'dropdown_token_to' => 'ETH',
            'btn_favourite' => 'btn_from'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('favourites', ['user_id' => $user->id, 'token_name' => $testToken]);

        $response = $this->post('/show-price', [
            'dropdown_token_from' => $testToken,
            'dropdown_token_to' => 'ETH',
            'btn_favourite' => 'btn_from'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('favourites', ['user_id' => $user->id, 'token_name' => $testToken]);
    }
}
