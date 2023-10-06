<?php

class Verify
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::instance();
    }

    public function generateLink()
    {
        return str_shuffle(substr(md5(time() . mt_rand() . time()), 0, 25));
    }

    public function sendToMail($email, $message, $subject)
    {
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth=true;
        $mail->SMTPDebug=0;
        $mail->Host=M_HOST;
        $mail->Username=M_USERNAME;
        $mail->Password=M_PASSWORD;
        $mail->SMTPSecure=M_SMTPSECURE;
        $mail->Port=M_PORT;

        if (!empty($email)){
            $mail->From="elias.cardon@laplateforme.io";
            $mail->FromName="Jobber";
            $mail->addReplyTo="no-reply@gmail.com";
            $mail->addAddress($email);

            $mail->Subject=$subject;
            $mail->Body=$message;
            $mail->AltBody=$message;

            if (!$mail->send()){
                return false;
            } else {
                return true;
            }
        }
    }
}