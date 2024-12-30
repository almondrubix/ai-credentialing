
$(document).ready(function () {
  $("#startInterviewBtn").on("click", function () {
    $.ajax({
      url: "backend/endpoints.php?action=start_interview",
      method: "GET",
      success: function (data) {
        if (data.scenario) {
          $("#scenarioText").text(data.scenario);
          $("#startInterviewBtn").hide();
          $("#scenarioContainer").show();
        }
      }
    });
  });

  $("#submitAnswerBtn").on("click", function () {
    const candidateAnswer = $("#answer").val();
    $.ajax({
      url: "backend/endpoints.php?action=submit_answer",
      method: "POST",
      data: { answer: candidateAnswer },
      success: function (data) {
        if (data.error) {
          alert(data.error);
          return;
        }
        if (data.scores) {
          $("#scoresOutput").text(JSON.stringify(data.scores));
          $("#scoresContainer").show();
        }
        if (data.followup) {
          $("#followupText").text(data.followup);
          $("#followupContainer").show();
        }
        // Optionally, you might keep showing the same answer field or
        // hide it if you only do a single Q&A before the final report.

        // Show final report button after some steps or immediately for testing:
        $("#finalReportBtn").show();
      }
    });
  });

  $("#finalReportBtn").on("click", function () {
    $.ajax({
      url: "backend/endpoints.php?action=get_final_report",
      method: "GET",
      success: function (data) {
        if (data.error) {
          alert(data.error);
          return;
        }
        $("#finalReportText").text(data.final_report);
        $("#finalReportContainer").show();
      }
    });
  });
});
