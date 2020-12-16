<?php

/* ------

  class Mail

  Sends Mail using PHPMailer

  https://github.com/PHPMailer/PHPMailer

------ */

  require_once "core/libraries/PHPMailer/src/PHPMailer.php";
  require_once "core/libraries/PHPMailer/src/SMTP.php";
  require_once "core/libraries/PHPMailer/src/Exception.php";

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;



  class Mail {

    function __construct() {}

    function sendMail() {

      $mail = new PHPMailer(true);

      try {

        //Server settings
//      $mail->SMTPDebug = SMTP::DEBUG_SERVER;              # Enable verbose debug output
        $mail->SMTPDebug = 0;
        $mail->isSMTP();                                    # Send using SMTP
        $mail->Host       = "yourdomain.com";               # Set the SMTP server to send through
        $mail->SMTPAuth   = true;                           # Enable SMTP authentication
        $mail->Username   = "email@yourdomain.com";         # SMTP username
        $mail->Password   = 'passpasspassword';             # SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;    # Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
//      $mail->SMTPSecure = "ssl";
        $mail->Port       = 465;                            # TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom("email@yourdomain.com","TEST");
        $mail->addReplyTo("email@yourdomain.com","TEST");
        $mail->addAddress($this->to, "Q");                  # Add a recipient
//      $mail->addAddress("aa@example.com");                # Name is optional
//      $mail->addCC('cc@example.com');
//      $mail->addBCC('bcc@example.com');

        // Attachments
//      $mail->addAttachment('/var/tmp/file.tar.gz');       # Add attachments
//      $mail->addAttachment('/tmp/image.jpg', 'new.jpg');  # Optional name

        // Content
        $mail->isHTML(true);                                # Set email format to HTML
        $mail->CharSet = "utf-8";
        $mail->setLanguage("es");
        $mail->ContentType = "text/html; charset=utf-8\r\n";
        $mail->Subject = $this->subject;
        $mail->Body    = $this->message;
        $mail->AltBody = nl2br($this->message);

        $mail->send();
        $this->done = true;

        }

      catch(Exception $e){

        $this->fail = true;

      }

      return true;

    }

  }

?>