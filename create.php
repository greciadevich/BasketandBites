<?php
if (session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_lifetime' => 0,
        'cookie_secure' => true,
        'cookie_httponly' => true,
        'cookie_samesite' => 'Strict'
    ]);
}
require_once('stripe/init.php');

$stripeSecretKey = 'sk_test_51IYyDsFC6aRzLeVR27CvZfZbvVeG3biofzhTbvI8ZoBaLsv4mx2IpzJDxIHcTApP3SC8k6Zd2H6IFs1mcdQMIRAu00ujrDPToz';

$stripe = new \Stripe\StripeClient($stripeSecretKey);

header('Content-Type: application/json');

try {
    // Create a PaymentIntent with amount and currency
    $paymentIntent = $stripe->paymentIntents->create([
        'amount' => number_format($_SESSION['total'] * 100, 0, '', ''),
        'currency' => 'eur',
        // In the latest version of the API, specifying the `automatic_payment_methods` parameter is optional because Stripe enables its functionality by default.
        'automatic_payment_methods' => [
            'enabled' => true,
        ],
    ]);

    $output = [
        'clientSecret' => $paymentIntent->client_secret,
    ];

    echo json_encode($output);
} catch (Error $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
