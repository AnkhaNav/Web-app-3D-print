<?php

$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

require "vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = 'smtp.gmail.com';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

$mail->Username = 'daniellekedro@gmail.com';
$mail->Password = 'JonasBlue24';

$mail->setFrom($email, $name);
$mail->addAddress('recipient_email@example.com', 'Recipient Name');

$mail->Subject = $subject;
$mail->Body = $message;

$mail->send();

header('Location: testmailsent.php');