<?php

// Script to setup JWT keys from environment variables
// This creates temporary files from the JWT keys stored in environment variables

$privateKey = $_ENV['JWT_SECRET_KEY'] ?? '';
$publicKey = $_ENV['JWT_PUBLIC_KEY'] ?? '';

if (empty($privateKey) || empty($publicKey)) {
    echo "JWT keys not found in environment variables\n";
    exit(1);
}

// Create JWT directory
$jwtDir = '/tmp/jwt';
if (!is_dir($jwtDir)) {
    mkdir($jwtDir, 0700, true);
}

// Write private key
$privateKeyPath = $jwtDir . '/private.pem';
file_put_contents($privateKeyPath, $privateKey);
chmod($privateKeyPath, 0600);

// Write public key
$publicKeyPath = $jwtDir . '/public.pem';
file_put_contents($publicKeyPath, $publicKey);
chmod($publicKeyPath, 0600);

echo "JWT keys written to temporary files:\n";
echo "Private key: $privateKeyPath\n";
echo "Public key: $publicKeyPath\n";

// Update environment variables to point to the files
$_ENV['JWT_SECRET_KEY'] = $privateKeyPath;
$_ENV['JWT_PUBLIC_KEY'] = $publicKeyPath;

echo "Environment variables updated to point to file paths\n";