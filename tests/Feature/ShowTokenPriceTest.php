<?php

namespace Tests\Feature;

use Tests\TestCase;

class ShowTokenPriceTest extends TestCase
{
    public function show_token_price(): void
    {
        $response = $this->get('/');

        $params = [
            'dropdown_token_from' => 'BTC',
            'dropdown_token_to' => 'ETH'
        ];

        $response = $this->get(
            '/show-price?dropdown_token_from=' . $params['dropdown_token_from'] . '&dropdown_token_to=' . $params['dropdown_token_to']
        );

        $response->assertStatus(200);
        $response->assertSee($params['dropdown_token_from']);
        $response->assertSee($params['dropdown_token_to']);
    }
}
