<?php

require 'vendor/autoload.php';

use PhilKra\Agent;

try {
    $agentConfig = [
        'appName'   => 'elastic-apm-app-demo-php-without-framework',
        'serverUrl' => 'http://apm-server:8200'
    ];

    $agentContext = [
        'user' => [
            'id'    => '3ce6262f-2c3e-4537-8d2e-f3815fa9564c',
            'email' => 'test@example.com'
        ]
    ];

    $agent = new Agent($agentConfig, $agentContext);

    $transaction = $agent->startTransaction('Simple Transaction' . $_GET['transaction_suffix'] ?? '' );
    for ($i = 0; $i < 100; $i++) {
        echo "Sample - $i <br />";
    }
    $agent->stopTransaction($transaction->getTransactionName());
    $agent->send();
} catch (Exception $e) {
    echo $e->getTraceAsString();
}
