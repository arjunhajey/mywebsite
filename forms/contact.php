<?php
// Set your email address where you want to receive messages
$receiving_email_address = 'ajunasimion7@gmail.com';

// Check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize form inputs
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST["subject"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    // Validate required fields
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        http_response_code(400);
        echo "Please fill in all required fields.";
        exit;
    }

    // Validate email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Invalid email format.";
        exit;
    }

    // Email content
    $email_subject = "New message from your portfolio website: $subject";
    $email_body = "You have received a new message from your website contact form.\n\n" .
                  "Name: $name\n" .
                  "Email: $email\n" .
                  "Subject: $subject\n\n" .
                  "Message:\n$message\n";

    // Email headers
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Try sending the email
    if (mail($receiving_email_address, $email_subject, $email_body, $headers)) {
        http_response_code(200);
        echo "Your message has been sent successfully. Thank you!";
    } else {
        http_response_code(500);
        echo "Sorry, your message could not be sent. Please try again later.";
    }

} else {
    http_response_code(403);
    echo "There was a problem with your submission. Please try again.";
}
?>
