
<?php
// followup.php
require_once 'ai_client.php';

function get_followup_question($scenario, $candidate_answer, $scores) {
    $template = file_get_contents(__DIR__ . '/../prompts/followup_prompt.txt');
    $search = ['{scenario}', '{candidate_answer}', '{scores}'];
    $replace = [$scenario, $candidate_answer, json_encode($scores)];
    $prompt = str_replace($search, $replace, $template);

    $response = ai_call($prompt);
    // Return it directly or do minimal checks
    return $response;
}
