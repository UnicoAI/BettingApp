<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true && isset($_POST['userId'])) {
    // Include your database connection script
    include "connection.php"; // Adjust the path as needed
    // ...

    // Get the user ID from the request
    $userId = $_POST['userId'];

    // Initialize arrays to store deposit and withdrawal data
    $deposits = array();
    $withdrawals = array();

    // Prepare and execute the query to fetch deposit data
    $stmt_deposits = $conn->prepare("SELECT * FROM deposits WHERE user_id = ?");
    $stmt_deposits->bind_param("i", $userId);
    $stmt_deposits->execute();
    $result_deposits = $stmt_deposits->get_result();

    // Fetch deposit data
    while ($row = $result_deposits->fetch_assoc()) {
        $deposits[] = $row;
    }

    // Prepare and execute the query to fetch withdrawal data
    $stmt_withdrawals = $conn->prepare("SELECT * FROM withdrawals WHERE user_id = ?");
    $stmt_withdrawals->bind_param("i", $userId);
    $stmt_withdrawals->execute();
    $result_withdrawals = $stmt_withdrawals->get_result();

    // Fetch withdrawal data
    while ($row = $result_withdrawals->fetch_assoc()) {
        $withdrawals[] = $row;
    }

    // Close the database connection
    $stmt_deposits->close();
    $stmt_withdrawals->close();
    $conn->close();

    // Combine deposit and withdrawal data
    $userData = array(
        "deposits" => $deposits,
        "withdrawals" => $withdrawals
    );

    // Send user data as JSON response
    header('Content-Type: application/json');
    echo json_encode($userData);
    exit;
} else {
    // User not logged in
    http_response_code(401); // Unauthorized
    echo json_encode(array("error" => "User not logged in"));
    exit;
}
?>
