<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'alerim');
define('DB_USER', 'alerim_user');
define('DB_PASS', '153118!Alex');

// Mining configuration
define('STRATUM_SERVER', 'mining-dutch.nl');
define('DEFAULT_USERNAME', 'Alexandru83');
define('REWARD_REDUCTION_PERCENTAGE', 35);

// API endpoints for price fetching
define('CRYPTO_PRICE_API', 'https://api.coingecko.com/api/v3');
define('GOLD_PRICE_API', 'https://metals-api.com/api/latest'); // You'll need to sign up for an API key

// Security
define('JWT_SECRET', 'your-secret-key-here'); // Change this to a secure random string
define('ENCRYPTION_KEY', 'your-encryption-key'); // Change this to a secure random string

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASS,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
