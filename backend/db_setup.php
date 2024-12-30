<?php
require_once 'config.php';

try {
    $db = new SQLite3($DB_PATH);

    $db->exec("CREATE TABLE IF NOT EXISTS sessions (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        start_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        current_stage TEXT,
        done INTEGER DEFAULT 0
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS responses (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        session_id INTEGER,
        scenario_text TEXT,
        candidate_answer TEXT,
        baseline TEXT,
        uniqueness INTEGER,
        teamwork INTEGER,
        biz_savvy INTEGER,
        conscientiousness INTEGER,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY(session_id) REFERENCES sessions(id)
    )");

    echo "Database setup completed successfully.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
