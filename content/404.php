<?php

  $meta["title"] = [
    "en" => "404 error",
    "es" => "Error 404",
    "gl" => "Erro 404",
  ];

  require_once $meta["themesDir"].$meta["theme"]."/header.php";
//require_once $meta["themesDir"].$meta["theme"]."/nav.php";

  $hi = [
    "en" => $meta["title"]["en"],
    "es" => $meta["title"]["es"],
    "gl" => $meta["title"]["gl"],
  ];

  $txt = [
    "en" => "Page not found.",
    "es" => "Página no encontrada.",
    "gl" => "Páxina non atopada.",
  ];

?>

<h1><?=$hi[$url->lang];?></h1>

<p><?=$txt[$url->lang];?></p>

<?php

  require_once $meta["themesDir"].$meta["theme"]."/footer.php";

?>
