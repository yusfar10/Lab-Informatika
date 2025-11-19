<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Mail\TestResetPassword;
use Illuminate\Support\Facades\Mail;

$user = User::where('email', 'admin@gmail.com')->first();

if ($user) {
    echo "User found: " . $user->name . PHP_EOL;
    echo "Sending email to: " . $user->email . PHP_EOL;

    try {
        Mail::to($user->email)->send(new TestResetPassword($user, 'test-token-123'));
        echo "Email sent successfully!" . PHP_EOL;
    } catch (Exception $e) {
        echo "Error sending email: " . $e->getMessage() . PHP_EOL;
    }
} else {
    echo "User not found!" . PHP_EOL;
}
