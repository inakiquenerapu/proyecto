<?php

return [

  "imgDir"     => "img/",
  "cssDir"     => "css/",
  "jsDir"      => "js/",
  "themesDir"  => "themes/",
  "contentDir" => "content/",

# -------------------------

  "theme" => "basic",

  "siteName" => [
    "en" => $site_name = "Project",
    "es" => $site_name = "Proyecto",
    "gl" => $site_name = "Proxecto",
    ],

  "title" => [
    "en" => $site_name." ".$version,
    "es" => $site_name." ".$version,
    "gl" => $site_name." ".$version,
    ],

  "date" => date("Y-m-d"),

  "description" => [
    "en" => "Generic description",
    "es" => "Descripción general",
    "gl" => "Descrición xeral",
    ],

  "keywords" => "Bla bla bla",

  "ogImageFile" => "image.jpg",

  "ogImageDescription" => [
    "en" => "Generic image description",
    "es" => "Descripción general de la imagen",
    "gl" => "Descrición xeral da imaxe",
    ],

  "ogImageAlt" => [
    "en" => "Generic image alt text",
    "es" => "Texto alternativo general para la imagen",
    "gl" => "Texto alternativo xeral para a imaxe",
    ],

# -------------------------

  "geoRegion" => "ES-GA",

  "geoPlacement" => [
    "en" => "Santiago de Compostela",
    "es" => "Santiago de Compostela",
    "gl" => "Santiago de Compostela",
    ],

  "geoPositionLat" => "42.863776",
  "geoPositionLon" => "-8.543034",

# -------------------------

];