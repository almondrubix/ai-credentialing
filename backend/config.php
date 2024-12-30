<?php
// config.php
//
// If using .env file, can load with something like vlucas/phpdotenv
// or rely on server env vars
//
$DB_PATH = __DIR__ . '/../data/data.db';
echo "DB Path: " . $DB_PATH . "\n";

// For environment variables, if set:
$OPENAI_API_KEY = getenv('OPENAI_API_KEY');

