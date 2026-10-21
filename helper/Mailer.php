<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/phpmailer/Exception.php';
require_once __DIR__ . '/../vendor/phpmailer/PHPMailer.php';
require_once __DIR__ . '/../vendor/phpmailer/SMTP.php';

class Mailer
{
    public static function enviarCorreoValidacion($emailDestino, $token)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'animequizsite@gmail.com';
            $mail->Password   = 'rgchioomjbtwxbmg';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom('animequizsite@gmail.com', 'Animequiz');
            $mail->addAddress($emailDestino);

            $protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
            $host = $_SERVER['HTTP_HOST'];
            $baseDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
            $link = "$protocolo://$host$baseDir/?controller=registro&method=activar&token=" . $token;

            $mail->isHTML(true);
            $mail->Subject = 'Activa tu cuenta en Animequiz';
            $mail->Body    = "
                <h2>¡Bienvenido a Animequiz!</h2>
                <p>Para activar tu cuenta y poder jugar, haz clic en el siguiente enlace:</p>
                <p><a href='$link' style='background:#F1CD73;color:#0A1A33;padding:10px 20px;text-decoration:none;border-radius:5px;font-weight:bold;'>Activar mi cuenta</a></p>
                <p>O copia este link en tu navegador:<br>$link</p>
            ";

            $mail->send();
            return true;
        } catch (Exception $e) {
            Log::error("Error enviando email: " . $mail->ErrorInfo);
            return false;
        }
    }
}
