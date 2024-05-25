<?php
require 'vendor/autoload.php'; // Assicurati che il percorso sia corretto

use GuzzleHttp\Client;

$client = new Client();

$username = 'YOUR_KLARNA_API_USERNAME'; // Sostituisci con il tuo username API
$password = 'YOUR_KLARNA_API_PASSWORD'; // Sostituisci con la tua password API

// Dati dell'ordine
$orderData = [
    'purchase_country' => 'SE',
    'purchase_currency' => 'SEK',
    'locale' => 'sv-SE',
    'order_amount' => 10000,
    'order_tax_amount' => 2000,
    'order_lines' => [
        [
            'type' => 'physical',
            'reference' => '123050',
            'name' => 'T-shirt',
            'quantity' => 2,
            'quantity_unit' => 'pcs',
            'unit_price' => 5000,
            'tax_rate' => 2500,
            'total_amount' => 10000,
            'total_discount_amount' => 0,
            'total_tax_amount' => 2000
        ]
    ],
    'merchant_urls' => [
        'terms' => 'https://www.example.com/terms',
        'checkout' => 'https://www.example.com/checkout',
        'confirmation' => 'https://www.example.com/confirmation',
        'push' => 'https://www.example.com/api/push'
    ]
];

try {
    $response = $client->post('https://api.playground.klarna.com/checkout/v3/orders', [
        'auth' => [$username, $password],
        'json' => $orderData
    ]);

    $order = json_decode($response->getBody(), true);
    echo 'Order ID: ' . $order['order_id'];
    echo 'Checkout URL: ' . $order['checkout']['url'];
} catch (Exception $e) {
    echo 'Errore: ' . $e->getMessage();
}
?>
