<?php

/* ------

  class Mail

  Sends Mail using the PHP mail function

  https://www.php.net/manual/es/function.mail.php

------ */

  class Mail {

    function sendMail() {

      $this->headers  = "MIME-Version: 1.0".PHP_EOL;
      $this->headers .= "Content-type:text/html;charset=UTF-8".PHP_EOL;

      if (mail(
            $this->to,
            $this->subject,
            $this->message,
            $this->headers
          ) !== false) :

        $this->done = true;

      else :

        $this->fail = true;

      endif;

    }

  }

?>
