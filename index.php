<?php

  $version = trim(fgets(fopen("version","r")));
  $meta = (array) require_once "core/general.conf.php";
  require_once("core/functions.php");
  require_once("core/url.class.php");
  $url = new Url(dirname($_SERVER["PHP_SELF"]));
  setlocale(LC_ALL,$url->langInfo["variant"]);

  $page = $meta["contentDir"]."404.php";
  $sec = false;

  if(isset($url->virtualPathArray[0]) && $url->virtualPathArray[0] != "") :

    if(file_exists($meta["contentDir"].$url->virtualPathArray[0].".php")) :

      $page = $meta["contentDir"].$url->virtualPathArray[0].".php";

    elseif(file_exists($meta["contentDir"].$url->virtualPathArray[0]."/index.php")) :

      $page = $meta["contentDir"].$url->virtualPathArray[0]."/index.php";
      $sec = true;

    endif;

  else :

    $page = $meta["contentDir"]."home.php";

  endif;

  require_once $page;

?>
