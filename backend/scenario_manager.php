
<?php
// scenario_manager.php
require_once 'ai_client.php';

function generate_initial_scenario() {
    // Option 1: Hardcode a scenario
    return "You are leading a team project that is behind schedule. How will you handle the situation?";
    
    // Option 2 (commented out): Use an AI-based generation from scenario_prompts.txt
    /*
    $prompt = file_get_contents(__DIR__ . '/../prompts/scenario_prompts.txt');
    // Potentially modify or process $prompt
    return ai_call($prompt);
    */
}
