<?php

  $meta["title"] = [
    "en" => "More",
    "es" => "Más",
    "gl" => "Máis",
  ];

  require_once $meta["themesDir"].$meta["theme"]."/header.php";
//require_once $meta["themesDir"].$meta["theme"]."/nav.php";

  $hi = [
    "en" => $meta["title"]["en"],
    "es" => $meta["title"]["es"],
    "gl" => $meta["title"]["gl"],
  ];

  $txt = [
    "en" => "This page is the more.php file.",
    "es" => "Esta página es el archivo more.php.",
    "gl" => "Esta páxina é o arquivo more.php.",
  ];

?>

<h1><?=$hi[$url->lang];?></h1>

<p><?=$txt[$url->lang];?></p>

<?php

  require_once $meta["themesDir"].$meta["theme"]."/footer.php";

?>
