<?php declare(strict_types = 1);

use function Pest\Laravel\{assertDatabaseCount, postJson};

beforeEach(function () {
    $this->data = [
        "data" => [
            "product" => [
                "has_co_production" => false,
                "name"              => "Nome do Produto",
                "id"                => 24, // ID DO PRODUTO
                "ucode"             => "9e733dbe-27d3-4214-9cd6-94a1e7bac0e7",
            ],
            "commissions" => [
                ["currency_value" => "USD", "source" => "MARKETPLACE", "value" => 72.28],
                ["currency_value" => "USD", "source" => "PRODUCER", "value" => 924.72],
            ],
            "purchase" => [
                "original_offer_price"               => ["currency_value" => "USD", "value" => 997],
                "subscription_anticipation_purchase" => false,
                "checkout_country"                   => ["iso" => "US", "name" => "United States"],
                "order_bump"                         => ["is_order_bump" => false],
                "approved_date"                      => 1706815890000,
                "offer"                              => ["code" => ""],
                "order_date"                         => 1706815888000,
                "price"                              => ["currency_value" => "USD", "value" => 997],
                "payment"                            => ["installments_number" => 1, "type" => "CREDIT_CARD"],
                "full_price"                         => ["currency_value" => "USD", "value" => 997],
                "invoice_by"                         => "HOTMART",
                "transaction"                        => "HP2242007974",
                "status"                             => "APPROVED",
            ],
            "affiliates" => [["affiliate_code" => null, "name" => null]],
            "producer"   => ["name" => "Produtor"],
            "buyer"      => [
                "address"        => ["country" => "United States"],
                "document"       => "F2458797",
                "name"           => "Aluno dos Santos Silva",
                "checkout_phone" => "17073313164",
                "email"          => "20@gmail.com",
            ],
        ],
        "id"            => "d55bb2e3-a8cc-4185-9cb8-b2718dc6133c",
        "creation_date" => 1706815894458,
        "event"         => "PURCHASE_APPROVED",
        "version"       => "2.0.0",
    ];
});

it('should be able to create a webhook', function () {
    postJson(route('webhooks.hotmart'), [
        'header' => [
            'Content-Type' => 'application/json',
        ],

        'body' => $this->data,
    ])->assertCreated();

    assertDatabaseCount('webhooks', 1);
});
