<?php

  $meta["title"] = [
    "en" => "About",
    "es" => "Acerca de",
    "gl" => "Acerca de",
  ];

  require_once $meta["themesDir"].$meta["theme"]."/header.php";

  $hi = [
    "en" => $meta["title"]["en"],
    "es" => $meta["title"]["es"],
    "gl" => $meta["title"]["gl"],
  ];

  $txt = [
    "en" => "About page.",
    "es" => "Página sobre este sitio.",
    "gl" => "Páxina sobre este sitio.",
  ];

?>

<h1><?=$hi[$url->lang];?></h1>

<p><?=$txt[$url->lang];?></p>

<?php

  require_once $meta["themesDir"].$meta["theme"]."/footer.php";

?>
