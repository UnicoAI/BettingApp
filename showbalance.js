document.addEventListener("DOMContentLoaded", function() {
    // Function to fetch user data and update balance
    const updateBalance = () => {
        // Check if user is logged in
        const loggedIn = localStorage.getItem("loggedIn");
        if (loggedIn) {
            // Fetch user data from the server
            const userId = localStorage.getItem("userId");
            fetch("fetch_user_data.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "userId=" + userId
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Failed to fetch user data");
                }
                return response.json();
            })
            .then(userData => {
                // Display user balance
                document.getElementById("showbalancemobile").innerHTML = '£' + userData.balance;
                document.getElementById("showbalancebet").innerHTML = '🤖 Stake: ' + userData.unicoin_stake;
                document.getElementById("showbalancedesktop").innerHTML = '£ '+ userData.balance + ' <br/>🤖 Stake: ' + userData.unicoin_stake;
            })
            .catch(error => {
                console.error("Error:", error);
            });
        } else {
            // Redirect to login page if user is not logged in
            console.log("Anonymous User!");
        }
    };

    // Call the function initially
    updateBalance();

    // Set interval to update balance every 1 second
    setInterval(updateBalance, 60000);
});
