<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Mail;
use App\Mail\TestResetPassword;
use App\Models\User;
use Illuminate\Support\Facades\Password;

$user = User::where('email', 'admin@gmail.com')->first();
if (!$user) {
    echo "User not found\n";
    exit(1);
}

$token = Password::createToken($user);
echo "User found: " . $user->name . "\n";
echo "Sending email to: " . $user->email . "\n";

try {
    Mail::to($user->email)->send(new TestResetPassword($user, $token));
    echo "Email sent successfully!\n";
} catch (Exception $e) {
    echo "Error sending email: " . $e->getMessage() . "\n";
}
