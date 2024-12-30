<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>AI Credentialing - Step 2</title>
    <style>
        body { font-family: sans-serif; background: #f0f0f0; }
        .container { margin: 20px auto; max-width: 600px; background: #fff; padding: 20px; }
        h1 { color: #333; }
    </style>
</head>
<body>
<div class="container">
    <h1>AI Credentialing - Basic UI</h1>
    <button id="startBtn">Start Interview</button>
    <div id="scenarioContainer" style="display:none; margin-top:20px;">
        <h3>Scenario</h3>
        <div id="scenarioText"></div>
        <textarea id="candidateAnswer" rows="4" cols="50"></textarea><br><br>
        <button id="submitAnswerBtn">Submit Answer</button>
    </div>
</div>
</body>
</html>
