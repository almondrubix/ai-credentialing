document.addEventListener("DOMContentLoaded", () => {
  const startBtn = document.getElementById("startBtn");
  const scenarioContainer = document.getElementById("scenarioContainer");


  startBtn.addEventListener("click", () => {
    // Reveal the scenario container
    scenarioContainer.style.display = "block";

    // Show a mock scenario text
    const scenarioText = document.getElementById("scenarioText");
    scenarioText.innerText = "You are behind schedule on a team project. What do you do?";
  });

});
