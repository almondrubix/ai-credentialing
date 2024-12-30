
<?php
// baseline.php
require_once 'ai_client.php';

function get_baseline_answer($scenario_text) {
    $template = file_get_contents(__DIR__ . '/../prompts/baseline_prompt.txt');
    $prompt = str_replace('{scenario}', $scenario_text, $template);
    return ai_call($prompt);
}
