document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault();

    const cell = document.getElementById("phonelogin").value;
    const pass = document.getElementById("passwordlogin").value;

    // Data to be sent as form data
    const formData = new FormData();
    formData.append('cell', cell); // Use 'cell' instead of 'mobile'
    formData.append('pass', pass); // Use 'pass' instead of 'password'

    // Headers
    const headers = {
        'x-token': '123456789'
    };

    // Fetch options
    const options = {
        method: 'POST',
        headers: headers,
        body: formData // Send form data
    };

    // URL to send the request
    const url = 'https://revencu.com/login';

    // Send the request
    fetch(url, options)
        .then(response => {
            if (!response.ok) {
                throw new Error("Failed to login");
            }
            return response.json();
        })
        .then(data => {
            // Check if login was successful
            if (data.status === "OK") {
                // Store user data in local storage
                console.log("User ID:", data.userId);
                document.getElementById("message").innerText = "Login Successful";
                localStorage.setItem("loggedIn", true);
                localStorage.setItem("userId", data.userId); // Assuming the response contains the user ID
                localStorage.setItem("cell", cell);
                
                // Redirect to profile page
                window.location.href = "user/";
            } else {
                document.getElementById("message").innerText = "Invalid phone or password";
            }
        })
        .catch(error => {
            document.getElementById("message").innerText = error.message;
        });
});
