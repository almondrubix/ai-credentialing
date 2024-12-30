
<?php
// db.php
require_once 'config.php';

function db_connect() {
    static $db = null;
    if ($db === null) {
        $db = new SQLite3($GLOBALS['DB_PATH']);
    }
    return $db;
}

function insert_response($session_id, $scenario_text, $candidate_answer, $baseline, $scores) {
    $db = db_connect();
    $stmt = $db->prepare("INSERT INTO responses
        (session_id, scenario_text, candidate_answer, baseline, uniqueness, teamwork, biz_savvy, conscientiousness)
        VALUES (:session_id, :scenario_text, :candidate_answer, :baseline, :uniqueness, :teamwork, :biz_savvy, :conscientiousness)");
    $stmt->bindValue(':session_id', $session_id, SQLITE3_INTEGER);
    $stmt->bindValue(':scenario_text', $scenario_text, SQLITE3_TEXT);
    $stmt->bindValue(':candidate_answer', $candidate_answer, SQLITE3_TEXT);
    $stmt->bindValue(':baseline', $baseline, SQLITE3_TEXT);
    $stmt->bindValue(':uniqueness', $scores['uniqueness'], SQLITE3_INTEGER);
    $stmt->bindValue(':teamwork', $scores['teamwork'], SQLITE3_INTEGER);
    $stmt->bindValue(':biz_savvy', $scores['biz_savvy'], SQLITE3_INTEGER);
    $stmt->bindValue(':conscientiousness', $scores['conscientiousness'], SQLITE3_INTEGER);

    $stmt->execute();
}

function get_session($session_id) {
    $db = db_connect();
    $stmt = $db->prepare("SELECT * FROM sessions WHERE id=:id");
    $stmt->bindValue(':id', $session_id, SQLITE3_INTEGER);
    return $stmt->execute()->fetchArray(SQLITE3_ASSOC);
}

function update_session_stage($session_id, $new_stage) {
    $db = db_connect();
    $stmt = $db->prepare("UPDATE sessions SET current_stage=:stage WHERE id=:id");
    $stmt->bindValue(':stage', $new_stage, SQLITE3_TEXT);
    $stmt->bindValue(':id', $session_id, SQLITE3_INTEGER);
    $stmt->execute();
}

function mark_session_done($session_id) {
    $db = db_connect();
    $stmt = $db->prepare("UPDATE sessions SET done=1 WHERE id=:id");
    $stmt->bindValue(':id', $session_id, SQLITE3_INTEGER);
    $stmt->execute();
}

function create_session() {
    $db = db_connect();
    $stmt = $db->prepare("INSERT INTO sessions (current_stage, done) VALUES ('scenario1', 0)");
    $stmt->execute();
    return $db->lastInsertRowID();
}

function get_all_responses_for_session($session_id) {
    $db = db_connect();
    $stmt = $db->prepare("SELECT * FROM responses WHERE session_id=:session_id");
    $stmt->bindValue(':session_id', $session_id, SQLITE3_INTEGER);
    $result = $stmt->execute();

    $responses = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $responses[] = $row;
    }
    return $responses;
}
