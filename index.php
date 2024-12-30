
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>AI Credentialing Interview</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<div id="app">
    <button id="startInterviewBtn">Start Interview</button>
    
    <div id="scenarioContainer" style="display:none;">
        <h3>Scenario</h3>
        <div id="scenarioText"></div>
        
        <textarea id="answer" rows="5" cols="80"></textarea><br>
        <button id="submitAnswerBtn">Submit Answer</button>
    </div>
    
    <div id="scoresContainer" style="display:none;">
        <h4>Scores</h4>
        <div id="scoresOutput"></div>
    </div>

    <div id="followupContainer" style="display:none;">
        <h3>Next Scenario/Question</h3>
        <div id="followupText"></div>
    </div>
    
    <button id="finalReportBtn" style="display:none;">Get Final Report</button>

    <div id="finalReportContainer" style="display:none;">
        <h3>Final Report</h3>
        <div id="finalReportText"></div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
