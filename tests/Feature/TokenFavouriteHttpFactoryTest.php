<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TokenFavouriteHttpFactoryTest extends TestCase
{
    public function test_like_token_functionality(): void
    {
        $user = User::factory()->create();
        $testToken = 'ACS';

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

        User::where('email', Auth::user()->email)->delete();
    }
}
