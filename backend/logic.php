
<?php
// logic.php

require_once 'db.php';
require_once 'scenario_manager.php';
require_once 'baseline.php';
require_once 'scoring.php';
require_once 'followup.php';

function start_interview() {
    // Create new session
    $session_id = create_session();

    // Generate initial scenario
    $scenario_text = generate_initial_scenario();

    // Return it, along with session_id
    return [
        'session_id' => $session_id,
        'scenario'   => $scenario_text
    ];
}

function submit_answer($session_id, $candidate_answer) {
    // Fetch current session to get stage, but for simplicity:
    $session = get_session($session_id);
    
    // If session is done, or not found, handle that
    if (!$session || $session['done']) {
        return [
            'error' => 'Session not valid or already completed.'
        ];
    }
    
    $scenario_text = "Unknown scenario";
    if ($session['current_stage']) {
        // For the first scenario, we used scenario_manager. 
        // Optionally store the scenario in the session or retrieve from responses, but here it’s simplified:
        $scenario_text = ($session['current_stage'] === 'scenario1')
            ? generate_initial_scenario()
            : "Follow-up scenario here..."; // or store it in DB if you want to track each scenario precisely
    }

    // Get baseline
    $baseline = get_baseline_answer($scenario_text);

    // Score
    $scores = score_candidate_answer($scenario_text, $candidate_answer, $baseline);

    // Insert response into db
    insert_response($session_id, $scenario_text, $candidate_answer, $baseline, $scores);

    // Generate next scenario or followup question
    $followup = get_followup_question($scenario_text, $candidate_answer, $scores);

    // Update the session stage (e.g. scenario2, or followup1, etc.)
    update_session_stage($session_id, "followup1");

    return [
        'scores'   => $scores,
        'followup' => $followup
    ];
}

function get_final_report($session_id) {
    // Mark session as done
    mark_session_done($session_id);

    // Fetch all responses
    $responses = get_all_responses_for_session($session_id);

    // Aggregate
    $count = count($responses);
    $uniqueness_sum = 0;
    $teamwork_sum = 0;
    $biz_savvy_sum = 0;
    $conscientious_sum = 0;

    $all_answers = [];
    foreach ($responses as $r) {
        $uniqueness_sum += $r['uniqueness'];
        $teamwork_sum += $r['teamwork'];
        $biz_savvy_sum += $r['biz_savvy'];
        $conscientious_sum += $r['conscientiousness'];
        $all_answers[] = $r['candidate_answer'];
    }

    if ($count > 0) {
        $uniqueness_avg = $uniqueness_sum / $count;
        $teamwork_avg = $teamwork_sum / $count;
        $biz_savvy_avg = $biz_savvy_sum / $count;
        $conscientious_avg = $conscientious_sum / $count;
    } else {
        $uniqueness_avg = $teamwork_avg = $biz_savvy_avg = $conscientious_avg = 3;
    }

    // Generate final report via AI
    $template = file_get_contents(__DIR__ . '/../prompts/final_report_prompt.txt');
    $search = [
        '{uniqueness_avg}',
        '{teamwork_avg}',
        '{biz_savvy_avg}',
        '{conscientiousness_avg}',
        '{all_candidate_answers}'
    ];
    $replace = [
        $uniqueness_avg,
        $teamwork_avg,
        $biz_savvy_avg,
        $conscientious_avg,
        implode("\n\n", $all_answers)
    ];
    $prompt = str_replace($search, $replace, $template);

    $final_report = ai_call($prompt);

    return [
        'final_report' => $final_report
    ];
}
