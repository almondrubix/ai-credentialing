
<?php
// ai_client.php
require_once 'config.php';

function ai_call($prompt) {
    // Minimal example for OpenAI
    global $OPENAI_API_KEY, $AI_MODEL;

    $endpoint = "https://api.openai.com/v1/completions";
    $headers = [
        "Content-Type: application/json",
        "Authorization: Bearer $OPENAI_API_KEY"
    ];

    $data = [
        "model" => $AI_MODEL,
        "prompt" => $prompt,
        "max_tokens" => 200,
        "temperature" => 0.7,
    ];

    $ch = curl_init($endpoint);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        // minimal error handling
        return "Error calling AI.";
    }
    curl_close($ch);

    $decoded = json_decode($result, true);
    if (isset($decoded['choices'][0]['text'])) {
        return trim($decoded['choices'][0]['text']);
    } else {
        return "No valid response from AI.";
    }
}
