<?php

  require_once("core/links.class.php");
  $links = new Links(
    $url->baseUrl,
    ($url->multilingual??false),
    $url->lang,
    ($url->virtualPathArray[0]??false),
    $url->virtualPathNoLang,
    $url->query,
    );

?>
  <nav>

    <?= $links->item("🏠"); ?>
    <?= $links->item("Home"); ?>
    <?= $links->item("El País", "!https://elpais.com"); ?>
    <?= $links->item("El País", "!https://elpais.com", "div"); ?>
    <?= $links->item("Microsiervos","https://microsiervos.com", "p", "link-id", "link-class"); ?>
    <?= $links->item("📯","contact", "p"); ?>
    <?= $links->item("📌","!about", "p", "about-id", "about-class"); ?>

    <?= $links->langs($url->langs); ?>
    <?= $links->langs($url->langs, "p|span"); ?>

    <?= $links->list($meta["navLinks"]); ?>
    <?= $links->list($meta["navLinks"], "p|span"); ?>

  </nav>
