<?php
session_start();
include "connection.php";

if (isset($_POST['loginSubmit'])) {
    $identifier = $_POST['phoneloginr']; // Email or phone number
    $passwordr = $_POST['passwordloginr']; // Password

    // Use an alternate connection for specific email
    if (strtolower($identifier) === 'maria@unicoais.com') {
        include "connectionunico.php";
    }

    // Function to fetch user details
    function fetchUserDetails($identifier, $conn) {
        if (!$conn) {
            return null;
        }

        $stmt = $conn->prepare("SELECT id, phone, password FROM users WHERE LOWER(email) = LOWER(?) OR phone = ?");
        if (!$stmt) {
            return null;
        }

        $stmt->bind_param("ss", $identifier, $identifier);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            return $result->fetch_assoc();
        }

        return null;
    }

    // Check database connection and fetch user details
    if (!$conn) {
        echo "<script>alert('Database connection failed. Please try again later.'); history.back();</script>";
        exit;
    }

    $user = fetchUserDetails($identifier, $conn);

    // Validate user and password
    if ($user && password_verify($passwordr, $user['password'])) {
        $_SESSION['localuserId'] = $user['id'];
        $_SESSION['phone'] = $user['phone'];
        $_SESSION['loggedIn'] = true;

        // Redirect based on user ID
        $userRedirects = [
            1 => 'whitehat/bot',
            // Add more redirects as needed
        ];

        header('Location: ' . ($userRedirects[$user['id']] ?? 'whitehat/bot'));
        exit;
    } else {
        echo "<script>alert('Invalid email or password'); history.back();</script>";
        exit;
    }
}
?>
