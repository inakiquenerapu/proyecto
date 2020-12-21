<?php

  if(
         isset($_POST["contact-name"])
      && isset($_POST["contact-email"])
      && isset($_POST["contact-subject"])
      && isset($_POST["contact-message"])
    ) :

//  require "core/mail.class.php"; # Using PHP's mail
    require "core/phpmailer.class.php"; # Using PHPMailer class https://github.com/PHPMailer/PHPMailer

    $contact = new Mail();

    $contact->to      = "quenerapu@gmail.com";
    $contact->subject = $_POST["contact-name"].": ".$_POST["contact-subject"];
    $contact->message = $_POST["contact-name"].
                        " <a href=\"mailto:".$_POST["contact-email"]."\">".$_POST["contact-email"]."</a> :".
                        "<br>".nl2br($_POST["contact-message"]);
    $contact->sendMail();

    if(isset($contact->fail)) : $_SESSION["contactFormFail"] = true; endif;
    if(isset($contact->done)) : $_SESSION["contactFormDone"] = true; endif;
    header("Location: {$_SERVER['REQUEST_URI']}", true, 303);
    die();

  endif;

  $meta["title"] = [
    "en" => "Contact page",
    "es" => "Página de contacto",
    "gl" => "Páxina de contacto",
  ];

  require_once $meta["themesDir"].$meta["theme"]."/header.php";

  $hi = [
    "en" => $meta["title"]["en"],
    "es" => $meta["title"]["es"],
    "gl" => $meta["title"]["gl"],
  ];

  $messageSent = [
    "en" => "Message sent",
    "es" => "Mensaje enviado",
    "gl" => "Mensaxe enviada",
  ];

  $error = [
    "en" => "Error",
    "es" => "Error",
    "gl" => "Erro",
  ];

  $name = [
    "en"=> "Name",
    "es"=> "Nombre",
    "gl"=> "Nome",
  ];

  $email = [
    "en"=> "eMail",
    "es"=> "Correo electrónico",
    "gl"=> "Correo electrónico",
  ];

  $subject = [
    "en"=> "Subject",
    "es"=> "Tema",
    "gl"=> "Tema",
  ];

  $message = [
    "en"=> "Message",
    "es"=> "Mensaje",
    "gl"=> "Mensaxe",
  ];

  $send = [
    "en"=> "Send",
    "es"=> "Enviar",
    "gl"=> "Enviar",
  ];

?>

<h1><?=$hi[$url->lang];?></h1>

<form id="contact" method="post">

<?php if(isset($_SESSION["contactFormFail"])) : unset($_SESSION["contactFormFail"]); ?>
  <div class="alert">
    <?=$error[$url->lang];?>
  </div>
<?php elseif(isset($_SESSION["contactFormDone"])) : unset($_SESSION["contactFormDone"]); ?>
  <div class="done">
    <?=$messageSent[$url->lang];?>
  </div>
<?php endif; ?>

  <div class="row">
    <label for="contact-name"><?=$name[$url->lang];?>:</label>
    <input type="text" id="contact-name" name="contact-name" value="" required />
  </div>

  <div class="row">
    <label for="contact-email"><?=$email[$url->lang];?>:</label>
    <input type="email" id="contact-email" name="contact-email" value="" required />
  </div>

  <div class="row">
    <label for="contact-subject"><?=$subject[$url->lang];?>:</label>
    <input type="text" id="contact-subject" name="contact-subject" value="" required />
  </div>

  <div class="row">
    <label for="contact-message"><?=$message[$url->lang];?>:</label>
    <textarea id="contact-message" name="contact-message" required></textarea>
  </div>

  <div class="row">
    <input type="submit" name="send" value="<?=$send[$url->lang];?>" />
  </div>

</form>



<?php

  require_once $meta["themesDir"].$meta["theme"]."/footer.php";

?>
