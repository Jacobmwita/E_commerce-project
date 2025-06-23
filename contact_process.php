<?php
// php/contact_process.php

// This file handles the form submission from contact.php
// It connects to a MySQL database and stores the contact message.
// It now also sets the message as 'unread' by default.

// Database connection details
$servername = "sql309.infinityfree.com";
$username_db = "if0_39300768";
$password_db = "jdFPQTdFVtaEszn";
$dbname = "if0_39300768_portfolio_db";
// Create connection
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    // In a real app, log this error securely. For now, redirect with a generic error.
    header("Location: ../contact.php?status=error&msg=" . urlencode("Server error. Please try again later."));
    exit();
}

// Check if the form was submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Basic server-side validation
    if (empty($name) || empty($email) || empty($message)) {
        header("Location: ../contact.php?status=error&msg=" . urlencode("Please fill all required fields (Name, Email, Message)."));
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../contact.php?status=error&msg=" . urlencode("Invalid email format."));
        exit();
    }

    // Prepare SQL statement to prevent SQL injection
    // Add is_read column, defaulting to FALSE (unread)
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, subject, message, is_read) VALUES (?, ?, ?, ?, FALSE)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    // Execute the statement
    if ($stmt->execute()) {
        // --- Email Notification Start ---
        $to = "jacobmwita30@gmail.com"; // Your email address
        $email_subject = "New Portfolio Contact from " . $name;
        $email_body = "You have received a new message from your portfolio contact form.\n\n" .
                      "Name: " . $name . "\n" .
                      "Email: " . $email . "\n" .
                      "Subject: " . ($subject ?: "No Subject") . "\n" . // Use "No Subject" if empty
                      "Message:\n" . $message;
        $headers = "From: noreply@yourportfolio.com\r\n"; // Use an email associated with your domain or server
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Attempt to send the email
        if (mail($to, $email_subject, $email_body, $headers)) {
            // Email sent successfully (from PHP's perspective, doesn't guarantee delivery)
            // You might log this success or handle it silently.
            error_log("Notification email sent to " . $to);
        } else {
            // Email sending failed
            error_log("Failed to send notification email to " . $to . " from contact form.");
        }
        // --- Email Notification End ---

        // Redirect back to contact page with success message
        header("Location: ../contact.php?status=success&msg=" . urlencode("Your message has been sent successfully! I will get back to you soon."));
    } else {
        // If execution fails, redirect back with an error
        error_log("Error inserting contact message: " . $stmt->error); // Log the actual error for debugging
        header("Location: ../contact.php?status=error&msg=" . urlencode("There was an error sending your message. Please try again later."));
    }

    // Close the statement
    $stmt->close();
} else {
    // If accessed directly without POST request, redirect to contact page
    header("Location: ../contact.php");
}

// Close the database connection
$conn->close();
?>