
<?php
// scoring.php
require_once 'ai_client.php';

function score_candidate_answer($scenario, $candidate_answer, $baseline) {
    $template = file_get_contents(__DIR__ . '/../prompts/scoring_prompt.txt');
    $search = ['{scenario}', '{candidate_answer}', '{baseline}'];
    $replace = [$scenario, $candidate_answer, $baseline];
    $prompt = str_replace($search, $replace, $template);

    $response = ai_call($prompt);

    // Minimal error handling: parse JSON
    $scores = json_decode($response, true);
    if (!is_array($scores) || !isset($scores['uniqueness'])) {
        // fallback or retry
        // for now, return default values
        $scores = [
            'uniqueness' => 3,
            'teamwork' => 3,
            'biz_savvy' => 3,
            'conscientiousness' => 3
        ];
    }
    return $scores;
}
