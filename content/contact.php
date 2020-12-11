<?php

  $meta["title"] = [
    "en" => "Contact",
    "es" => "Contacto",
    "gl" => "Contacto",
  ];

  require_once $meta["themesDir"].$meta["theme"]."/header.php";
//require_once $meta["themesDir"].$meta["theme"]."/nav.php";

  $hi = [
    "en" => $meta["title"]["en"],
    "es" => $meta["title"]["es"],
    "gl" => $meta["title"]["gl"],
  ];

  $txt = [
    "en" => "Contact page.",
    "es" => "Página de contacto.",
    "gl" => "Páxina de contacto.",
  ];

?>

<h1><?=$hi[$url->lang];?></h1>

<p><?=$txt[$url->lang];?></p>

<?php

  require_once $meta["themesDir"].$meta["theme"]."/footer.php";

?>
