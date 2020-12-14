<?php

  # PRIVATE PAGE
  # Visible ONLY when user IS logged in

  if(!$login->isLogged()) :

    header("Location: ".$url->baseUrlLang);
    die();

  endif;

  $meta["title"] = [
    "en" => "Private page",
    "es" => "Página privada",
    "gl" => "Páxina privada",
  ];

  require_once $meta["themesDir"].$meta["theme"]."/header.php";
//require_once $meta["themesDir"].$meta["theme"]."/nav.php";

  $hi = [
    "en" => $meta["title"]["en"],
    "es" => $meta["title"]["es"],
    "gl" => $meta["title"]["gl"],
  ];

  $txt = [
    "en" => "This content can only be accesed when logged in.",
    "es" => "Este contenido sólo puede ser accedido cuando se ha iniciado sesión.",
    "gl" => "Este contido só pode ser accedido cando se ten iniciado sesión.",
  ];

?>

<h1><?=$hi[$url->lang];?></h1>

<p><?=$txt[$url->lang];?></p>

<?php

  require_once $meta["themesDir"].$meta["theme"]."/footer.php";

?>