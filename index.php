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

    $page = file_exists($meta["contentDir"].$meta["homePage"].".php") ?
            $meta["contentDir"].$meta["homePage"].".php" :
            (
              file_exists($meta["contentDir"].$meta["homePage"].".md") ?
              $meta["contentDir"].$meta["homePage"].".md" :
              false
            );

  endif;

  $extension = explode(".",$page);
  $fileName = explode("/",array_shift($extension));
  $extension = array_pop($extension);
  $fileName = array_pop($fileName);

  if($extension == "php"):

    require_once $page;

  elseif($extension == "md"):

    require_once "core/markdown.class.php";
    $html = new Markdown($page,$url);
    require_once $meta["themesDir"].$meta["theme"]."/header.php";
    echo $html->page;
    echo ($login->isLogged() ? "<h1><a class=\"noUnderline\" href=\"".$url->baseUrlLang.$meta["adminFile"]."/".$fileName."\">📝</a></h1>" : "");
    require_once $meta["themesDir"].$meta["theme"]."/footer.php";

  else:

    echo "Error: file not found.";

  endif;

?>
