// Handle Sign-In Form Submission
document.getElementById("signin-form").addEventListener("submit", function (event) {
  event.preventDefault(); // Prevent form from refreshing the page

  // Get User Input
  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;

  // Dummy Authentication Logic (Replace with real backend validation)
  const validEmail = "user@example.com";
  const validPassword = "password123";

  if (email === validEmail && password === validPassword) {
    // Store Sign-In Status in Local Storage
    localStorage.setItem("isLoggedIn", "true");

    // Redirect to Dashboard
    window.location.href = "dashboard.html";
  } else {
    alert("Invalid email or password. Please try again.");
  }
});
