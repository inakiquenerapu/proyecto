<?php

  $meta["title"] = [
    "en" => "Hello",
    "es" => "Hola",
    "gl" => "Ola",
  ];

  require_once $meta["themesDir"].$meta["theme"]."/header.php";

  $hi = [
    "en" => $meta["title"]["en"],
    "es" => $meta["title"]["es"],
    "gl" => $meta["title"]["gl"],
  ];

  $txt = [
    "en" => "Just a <strong>welcome message</strong> written using <strong>html</strong> syntax.",
    "es" => "Simplemente un <strong>mensaje de bienvenida</strong> escrito usando sintaxis <strong>html</strong>.",
    "gl" => "Simplemente unha <strong>mensaxe de benvida</strong> escrita usando sintaxe <strong>html</strong>.",
  ];

?>

<h1><?=$hi[$url->lang];?></h1>

<p><?=$txt[$url->lang];?></p>

<?php

  require_once $meta["themesDir"].$meta["theme"]."/footer.php";

?>
