<?php

  session_start();

  $version = trim(fgets(fopen("version","r")));
  date_default_timezone_set("Europe/Madrid");
  $meta = (array) require_once "core/general.conf.php";
  require_once("core/functions.php");
  require_once("core/url.class.php");
    $url = new Url(
      dirname($_SERVER["PHP_SELF"])
      );
    setlocale(LC_ALL,$url->langInfo["variant"]);
  require_once("core/links.class.php");
    $links = new Links(
      $url->baseUrl,
      ($url->multilingual??false),
      $url->lang,
      ($url->virtualPathArray[0]??false),
      $url->virtualPathNoLang,
      $url->query,
      );
  require_once("core/login.class.php");
    $login = new Login(
      $url->baseUrlLang
      );
    if($login->isLogged() && isset($_GET["logout"])) : $login->logout(); endif;

  $page = $meta["contentDir"]."404.php";
  $sec = false;

  if(isset($url->virtualPathArray[0]) && $url->virtualPathArray[0] != "") :

    if(file_exists($meta["contentDir"].$url->virtualPathArray[0].".php")) :

      $page = $meta["contentDir"].$url->virtualPathArray[0].".php";

    elseif(file_exists($meta["contentDir"].$url->virtualPathArray[0].".md")) :

      $page = $meta["contentDir"].$url->virtualPathArray[0].".md";

    elseif(file_exists($meta["contentDir"].$url->virtualPathArray[0]."/index.php")) :

      $page = $meta["contentDir"].$url->virtualPathArray[0]."/index.php";
      $sec = true;

    endif;

  else :

    $page = file_exists($meta["contentDir"]."home.php") ? 
            $meta["contentDir"]."home.php" :
            (
              file_exists($meta["contentDir"]."home.md") ?
              $meta["contentDir"]."home.md" :
              false
            );

  endif;

  $ext = explode(".",$page);
  $ext = array_pop($ext);

  if($ext == "php"):

    require_once $page;

  elseif($ext == "md"):

    require_once "core/markdown.class.php";
    $html = new Markdown($page,$url);
    require_once $meta["themesDir"].$meta["theme"]."/header.php";
//  require_once $meta["themesDir"].$meta["theme"]."/nav.php";
    echo $html->page;
    require_once $meta["themesDir"].$meta["theme"]."/footer.php";

  else:

    echo "Error: file not found.";

  endif;

?>
