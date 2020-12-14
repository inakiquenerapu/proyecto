<?php

/* ------

  class Login

  Logs in / out users

  Usage:

  $login = new Login();


  $text = "hello";
  echo password_hash($text, PASSWORD_BCRYPT, ["cost"=>12]);

------ */

  class Login {

    function __construct($baseUrlLang) {

      $this->baseUrlLang = $baseUrlLang;

    }



    function isLogged() {
    
      if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]) :

        return true;

      endif;

      return false;

    }



    function checkLoginForm() {

      $hashed_username = '$2y$12$1dX/Y62eIn7H4ICsNwo0L.mse3CU8p5Mi8zE3yQQ1kZUGu4KL9gpS';
      // Hash must be always enclosed with single quotes, NEVER DOUBLE QUOTES.

      $hashed_password = '$2y$12$b3cFZYn.9P9C0LnWk/ALzOFlol8nl.ZpOL8Q3hwlGtTiJFZOBY6GO';
      // Hash must be always enclosed with single quotes, NEVER DOUBLE QUOTES.

      if(
            password_verify($this->username,$hashed_username)
         && password_verify($this->password,$hashed_password)
        ) :

        $_SESSION["loggedin"] = true;
        header("location: ".$this->baseUrlLang);
        die();

      else :

        $this->fail = true;

      endif;

      return true;

    }


    function logout() {

      if($this->isLogged()) :

        $_SESSION = array();
        session_destroy();
        header("location: ".$this->baseUrlLang);
        die();

      endif;

    }

  }

?>