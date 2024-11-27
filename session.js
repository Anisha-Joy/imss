// Check Sign-In Status
const isLoggedIn = localStorage.getItem("isLoggedIn");

// If not signed in, redirect to the sign-in page
if (isLoggedIn !== "true") {
  window.location.href = "signin.html";
}
