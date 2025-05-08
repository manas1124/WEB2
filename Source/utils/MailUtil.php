<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

$mail = new PHPMailer(true);
$email = 'quangdeeptry1911@gmail.com'; //  email 
$password = 'hmayehbweofjrkzu'; // password
$nameMail = 'Quang tèo'; // tên người gửi

if (isset($_POST['act']) && $_POST['act']) {
    $listEmail = $_POST['listEmail'];
    $subject = $_POST['subject'];
    $body = $_POST['body'];
    sendMail($listEmail, $subject, $body);
}


function sendMail($listEmail, $subject, $body, $file = null)
{
    global $mail;
    global $email;
    global $password;
    global $nameMail;
    try {
        // Cấu hình SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $email;
        $mail->Password = $password;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        $mail->isHTML(true);
        // Người gửi & người nhận
        $mail->setFrom($email, $nameMail);

        // Nội dung
        foreach ($listEmail as $emailSendTo) {
            $mail->addAddress($emailSendTo);
        }

        if ($file != null) {
            $mail->addAttachment($file['tmp_name'], $file['name']);
        }   

        $mail->Subject = $subject;
        $mail->Body    = '<b>' . $body . '</b>';
        $mail->send();
        return json_encode([
            'status' => 'success',
            'message' => 'Gửi khảo sát thành công!'
        ]);
    } catch (Exception $e) {
        return json_encode([
            'status' => 'failed',
            'message' => 'Gửi khảo sát không thành công!',
        ]);
    }
}
