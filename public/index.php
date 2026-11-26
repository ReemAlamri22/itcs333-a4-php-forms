
<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/validate.php';

// Variables
$name = "";
$email = "";
$message = "";

$name_error = "";
$email_error = "";
$message_error = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get values from the form
    $name = $_POST['name'] ?? "";
    $email = $_POST['email'] ?? "";
    $message = $_POST['message'] ?? "";

    // Check name
    if (!validate_required($name)) {
        $name_error = "Name is required";
    } elseif (!validate_length($name, 2, 60)) {
        $name_error = "Name must be between 2 and 60 characters";
    }

    // Check email
    if (!validate_email($email)) {
        $email_error = "Please enter a valid email";
    }

    // Check message
    if (!validate_required($message)) {
        $message_error = "Message is required";
    } elseif (!validate_length($message, 10, 1000)) {
        $message_error = "Message must be between 10 and 1000 characters";
    }

    // If all fields are correct
    if ($name_error == "" && $email_error == "" && $message_error == "") {
        header("Location: index.php?success=1", true, 303);
        exit();
    }
}

// Function to protect output
function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
</head>
<body>

<?php
if (isset($_GET['success']) && $_GET['success'] == '1') {
?>

    <h1>Thank You!</h1>
    <p>Your message has been sent successfully.</p>
    <a href="index.php">Back to the form</a>

<?php
} else {
?>

    <h1>Contact Us</h1>

    <form method="POST" action="index.php">

        <label>Name:</label>
        <input type="text" name="name"
               value="<?php echo e($name); ?>">
        <?php echo e($name_error); ?>
        <br><br>

        <label>Email:</label>
        <input type="text" name="email"
               value="<?php echo e($email); ?>">
        <?php echo e($email_error); ?>
        <br><br>

        <label>Message:</label>
        <textarea name="message"><?php echo e($message); ?></textarea>
        <?php echo e($message_error); ?>
        <br><br>

        <button type="submit">Send</button>

    </form>

<?php
}
?>

</body>
</html>

