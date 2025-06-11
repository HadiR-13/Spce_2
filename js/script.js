document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".tab").forEach((tab) => {
    tab.addEventListener("click", () => {
      document.querySelectorAll(".tab").forEach((t) => t.classList.remove("active"));
      document.querySelectorAll(".user_detail").forEach((detail) => (detail.style.display = "none"));

      tab.classList.add("active");
      const target = tab.getAttribute("data-target");
      document.getElementById(target).style.display = "block";
    });
  });
});

const missionImage = document.getElementById("mission-img");
const missionName = document.getElementById("mission-name");
const missionDescription = document.querySelector(".mission-description");
const missionDuration = document.getElementById("mission-duration");
const missionEquipment = document.getElementById("mission-equipment");

const infoContainer = document.querySelector(".mission-info");
const imageContainer = document.querySelector(".mission-image img");

let missionsData = {};

// Load mission data from JSON
async function loadMissionsData() {
  try {
    const response = await fetch("./data/missions.json"); // Adjust path as needed
    missionsData = await response.json();

    // Initialize with first mission (Exploration)
    updateMissionContent(missionsData.Exploration);
  } catch (error) {
    console.error("Error loading missions data:", error);
  }
}

function updateMissionContent(data) {
  infoContainer.classList.add("fade-out");
  imageContainer.classList.add("fade-out");

  setTimeout(() => {
    missionName.textContent = data.name;
    missionDescription.textContent = data.description;
    missionDuration.textContent = data.duration;
    missionEquipment.textContent = data.equipment;
    missionImage.src = data.image;

    infoContainer.classList.remove("fade-out");
    imageContainer.classList.remove("fade-out");
    infoContainer.classList.add("fade-in");
    imageContainer.classList.add("fade-in");

    setTimeout(() => {
      infoContainer.classList.remove("fade-in");
      imageContainer.classList.remove("fade-in");
    }, 500);
  }, 300);
}

// Add click event listeners to mission tabs
function initializeMissionTabs() {
  const missionTabs = document.querySelectorAll(".mission-tabs li");

  missionTabs.forEach((tab) => {
    tab.addEventListener("click", () => {
      // Remove active class from all tabs
      missionTabs.forEach((t) => t.classList.remove("active"));

      // Add active class to clicked tab
      tab.classList.add("active");

      // Get mission data based on tab text
      const missionType = tab.textContent.trim();
      if (missionsData[missionType]) {
        updateMissionContent(missionsData[missionType]);
      }
    });
  });
}

// Initialize when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
  loadMissionsData();
  initializeMissionTabs();
});
