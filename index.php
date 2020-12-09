<?php

  require_once("core/url.class.php");
  $url = new Url(dirname($_SERVER["PHP_SELF"]));

  require "theme/header.php";

  if(isset($url->virtualPathNoLangArray[0])) {
 
    if(file_exists("content/".$url->virtualPathNoLangArray[0].".php")) {

      require "content/".$url->virtualPathNoLangArray[0].".php";

    } else {
    
      require "content/404.php";

    }

  } else {

    require "content/home.php";
  
  }

  require "theme/footer.php";

?>