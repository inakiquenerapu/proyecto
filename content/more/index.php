<?php

  $meta["title"] = [
    "en" => "More",
    "es" => "Más",
    "gl" => "Máis",
  ];

  require_once $meta["themesDir"].$meta["theme"]."/header.php";

  $hi = [
    "en" => $meta["title"]["en"],
    "es" => $meta["title"]["es"],
    "gl" => $meta["title"]["gl"],
  ];

  $txt = [
    "en" => "This page is inside the “more” directory.",
    "es" => "Esta página está dentro del directorio «more».",
    "gl" => "Esta páxina está dentro do directorio «more».",
  ];

?>

<h1><?=$hi[$url->lang];?></h1>

<p><?=$txt[$url->lang];?></p>

<?php

  require_once $meta["themesDir"].$meta["theme"]."/footer.php";

?>
