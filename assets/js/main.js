document.addEventListener("DOMContentLoaded", () => {
  const startBtn = document.getElementById("startBtn");
  const scenarioContainer = document.getElementById("scenarioContainer");

  startBtn.addEventListener("click", () => {
    // Reveal the scenario area for now, just for testing
    scenarioContainer.style.display = "block";
  });
});
