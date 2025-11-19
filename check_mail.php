<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Mail;

echo "Current mail config:\n";
$config = config('mail');
print_r($config);

echo "\nTesting Laravel Mail...\n";
try {
    Mail::raw('This is a test email from Laravel.', function ($message) {
        $message->to('admin@gmail.com')
                ->subject('Test Email from Laravel');
    });

    echo "Laravel Mail test successful!\n";
} catch (Exception $e) {
    echo "Laravel Mail test failed: " . $e->getMessage() . "\n";
}
