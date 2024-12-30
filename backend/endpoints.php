
<?php
// endpoints.php
header('Content-Type: application/json');

require_once 'logic.php';

// Start or resume a session. 
// Typically, you might use PHP sessions or a cookie-based approach to store $session_id.

$action = $_GET['action'] ?? '';
session_start();

// We'll store session_id in $_SESSION['session_id']
switch ($action) {
    case 'start_interview':
        $result = start_interview();
        $_SESSION['session_id'] = $result['session_id'];
        echo json_encode(['scenario' => $result['scenario']]);
        break;

    case 'submit_answer':
        $answer = $_POST['answer'] ?? '';
        if (!isset($_SESSION['session_id'])) {
            echo json_encode(['error' => 'No active session.']);
            exit;
        }
        $session_id = $_SESSION['session_id'];
        $result = submit_answer($session_id, $answer);
        echo json_encode($result);
        break;

    case 'get_final_report':
        if (!isset($_SESSION['session_id'])) {
            echo json_encode(['error' => 'No active session.']);
            exit;
        }
        $session_id = $_SESSION['session_id'];
        $report = get_final_report($session_id);
        echo json_encode($report);
        break;

    default:
        echo json_encode(['error' => 'Unknown action']);
        break;
}
