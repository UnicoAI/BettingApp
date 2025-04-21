<?php
session_start(); // Start the session

// Check if the form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve userId from the request body
    $requestData = json_decode(file_get_contents('php://input'));
    $userId = $requestData->userId;

    // Set userId in the session variable
    $_SESSION['userId'] = $userId;

    // Set userId in localStorage using JavaScript
    echo '<script>';
    echo 'localStorage.setItem("userId", ' . json_encode($userId) . ');';
    echo '</script>';

    // Send success response
    echo json_encode(['message' => 'Session set successfully']);
} else {
    // Send error response if the request method is not POST
    echo json_encode(['error' => 'Invalid request method']);
}
?>
