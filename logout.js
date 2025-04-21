function logout() {
    // Clear stored user data
    localStorage.removeItem("loggedIn");
    localStorage.removeItem("userId");
    localStorage.removeItem("phone");

    // Redirect to the login page
    window.location.href = "login/";
}
