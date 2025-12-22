<?php
session_start();
require_once "config/db.php";

// Set correct charset immediately after connection
$conn->set_charset("utf8mb4");

// User login check
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header("Location: auth/login.php");
    exit();
}

// Only POST allowed
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: contact.php");
    exit();
}

// Form Data
$purpose = $_POST['purpose'] ?? '';
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');
$service = ($purpose === "service") ? ($_POST['service'] ?? null) : null;

// Validation
if ($purpose == "" || $name == "" || !filter_var($email, FILTER_VALIDATE_EMAIL) || $message == "") {
    header("Location: contact.php?error=1");
    exit();
}

// Logged user ID
$userId = $_SESSION['user_id'] ?? null;

// Payment logic
$payment_status = ($purpose === "service") ? "Pending" : "Not Required";

// INSERT — always first!
$sql = "INSERT INTO contacts (user_id, name, email, purpose, service, message, payment_status)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL ERROR: " . $conn->error);
}

// Use 'issssss' for integer + 6 strings
$stmt->bind_param(
    "issssss",
    $userId,
    $name,
    $email,
    $purpose,
    $service,
    $message,
    $payment_status
);

// ⭐ ADD ERROR DEBUGGING — REQUIRED ⭐
if (!$stmt->execute()) {
    // If we catch the "Incorrect string value" error specifically, let's try to remove emojis as a last resort fallback
    if ($conn->errno == 1366) { // ER_TRUNCATED_WRONG_VALUE_FOR_FIELD
        $message = preg_replace('/[\xF0-\xF7].../s', '', $message);
        $message = preg_replace('/[\xE0-\xEF]../s', '', $message);

        // Retry insert without emojis
        $stmt->close();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssss", $userId, $name, $email, $purpose, $service, $message, $payment_status);
        if (!$stmt->execute()) {
            die("DB ERROR (Retry Failed): " . $stmt->error);
        }
    } else {
        die("DB ERROR: " . $stmt->error);
    }
}

$stmt->close();

// If Admin → direct admin panel without mail
if (!empty($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
    header("Location: admin/messages.php?new=1");
    exit();
}

// ✉ Send advanced emails
require_once "config/mailer.php";

// 1. Alert to Admin
$adminEmail = "sagarverses@gmail.com";
$adminSubject = "New $purpose Request from $name";
$adminMessage = "
    <div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ddd;'>
        <h3>New Contact Message 📩</h3>
        <p><b>Name:</b> $name</p>
        <p><b>Email:</b> $email</p>
        <p><b>Purpose:</b> $purpose</p>
        " . ($service ? "<p><b>Service:</b> $service</p>" : "") . "
        <p><b>Message:</b><br>" . nl2br(htmlspecialchars($message)) . "</p>
    </div>
";
sendEmail($adminEmail, $adminSubject, $adminMessage);

// 2. Thank you to User
$userSubject = "Message Received - SagarVerse 🚀";
$userMessage = "
    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #eee; border-radius: 10px;'>
        <h2 style='color: #8e3fd7;'>Message Sent! ✨</h2>
        <p>Hello <b>$name</b>,</p>
        <p>Thank you for reaching out to <b>SagarVerse</b>. We have received your message regarding: <b>$purpose</b>.</p>
        <p>Our team (Sagar) will review your request and get back to you within <b>12 hours</b>.</p>
        <hr style='border: 0; border-top: 1px solid #eee;'>
        <p style='font-size: 0.8rem; color: #888;'>This is an automated confirmation. Team SagarVerse</p>
    </div>
";
sendEmail($email, $userSubject, $userMessage);

// Redirect with success
header("Location: contact.php?sent=1");
exit();
?>