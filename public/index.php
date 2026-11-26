<?php
declare(strict_types=1);
error_reporting(E_ALL);

require_once __DIR__ . '/../src/validate.php';

$name = "";
$email = "";
$message = "";

$name_error = "";
$email_error = "";
$message_error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = isset($_POST['name']) && is_string($_POST['name']) ? trim($_POST['name']) : "";
    $email = isset($_POST['email']) && is_string($_POST['email']) ? trim($_POST['email']) : "";
    $message = isset($_POST['message']) && is_string($_POST['message']) ? trim($_POST['message']) : "";

    if (!validate_required($name)) {
        $name_error = "Name is required.";
    } elseif (!validate_length($name, 2, 60)) {
        $name_error = "Name must be 2-60 characters.";
    }

    if (!validate_required($email)) {
        $email_error = "Email is required.";
    } elseif (!validate_email($email)) {
        $email_error = "Enter a valid email address.";
    }

    if (!validate_required($message)) {
        $message_error = "Message is required.";
    } elseif (!validate_length($message, 10, 1000)) {
        $message_error = "Message must be 10-1000 characters.";
    }

    if ($name_error == "" && $email_error == "" && $message_error == "") {
        header("Location: success.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Contact Us</title>
</head>
<body>
  <h1>Contact Us</h1>
  <form method="post" action="index.php">
    <label>Name
      <input type="text" name="name" value="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>">
    </label>
    <span style="color:red"><?php echo htmlspecialchars($name_error, ENT_QUOTES, 'UTF-8'); ?></span><br>

    <label>Email
      <input type="email" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">
    </label>
    <span style="color:red"><?php echo htmlspecialchars($email_error, ENT_QUOTES, 'UTF-8'); ?></span><br>

    <label>Message
      <textarea name="message"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></textarea>
    </label>
    <span style="color:red"><?php echo htmlspecialchars($message_error, ENT_QUOTES, 'UTF-8'); ?></span><br>

    <button type="submit">Send</button>
  </form>
</body>
</html>

