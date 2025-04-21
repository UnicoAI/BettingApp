<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
    // Include your database connection script
    include "connection.php"; // Adjust the path as needed

    // Get the user ID from the session data
    $userId = $_SESSION['localuserId']; // Corrected typo here

    // Prepare and execute the query to fetch user balance
    $stmt = $conn->prepare("SELECT balance FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user data is found
    if ($result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Close the database connection
        $stmt->close();
        $conn->close();

        // Send user balance as JSON response
        header('Content-Type: application/json');
        echo json_encode($userData);
        //echo json_encode(['message' => $userData]);
        exit;
    } else {
        // User not found in the database
        http_response_code(404); // Not Found
        echo json_encode(array("error" => "User not found"));
        exit;
    }
} else {
    // User not logged in or user ID not provided
    http_response_code(401); // Unauthorized
    echo json_encode(array("error" => "User not logged in or user ID not provided"));
    exit;
}
?>
