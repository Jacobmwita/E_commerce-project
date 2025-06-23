<?php
session_start();

// Ensure only the logged-in owner can access this script
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../login.php"); // Redirect to login if not authenticated
    exit();
}

// Database connection details (repeated for self-contained file)
$servername = "sql309.infinityfree.com";
$username_db = "if0_39300768";
$password_db = "jdFPQTdFVtaEszn";
$dbname = "if0_39300768_portfolio_db";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    error_log("Database connection failed in message_actions.php: " . $conn->connect_error);
    header("Location: ../index.php?status=error&msg=" . urlencode("Database error. Could not perform action."));
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message_id = filter_var($_POST['message_id'], FILTER_SANITIZE_NUMBER_INT);
    $action = $_POST['action'] ?? '';

    if (!empty($message_id)) {
        if ($action === 'mark_read') {
            $stmt = $conn->prepare("UPDATE contacts SET is_read = TRUE WHERE id = ?");
            $stmt->bind_param("i", $message_id);
            if ($stmt->execute()) {
                header("Location: ../index.php?status=success&msg=" . urlencode("Message marked as read."));
            } else {
                error_log("Error marking message as read: " . $stmt->error);
                header("Location: ../index.php?status=error&msg=" . urlencode("Failed to mark message as read."));
            }
            $stmt->close();
        } elseif ($action === 'delete') {
            $stmt = $conn->prepare("DELETE FROM contacts WHERE id = ?");
            $stmt->bind_param("i", $message_id);
            if ($stmt->execute()) {
                header("Location: ../index.php?status=success&msg=" . urlencode("Message deleted successfully."));
            } else {
                error_log("Error deleting message: " . $stmt->error);
                header("Location: ../index.php?status=error&msg=" . urlencode("Failed to delete message."));
            }
            $stmt->close();
        } else {
            header("Location: ../index.php?status=error&msg=" . urlencode("Invalid action requested."));
        }
    } else {
        header("Location: ../index.php?status=error&msg=" . urlencode("Invalid message ID."));
    }
} else {
    // If accessed directly without POST request, redirect
    header("Location: ../index.php");
}

$conn->close();
?>
