<?php

  $meta = isset($html->headerMeta) ? array_merge($meta,$html->headerMeta) : $meta;

//  PHP < 7.3: addslashes($str);
//  PHP > 7.3: filter_var($str, FILTER_SANITIZE_ADD_SLASHES);

?><!DOCTYPE html>
<html lang="<?=$url->langInfo["variant"];?>">
<head>

  <meta charset="UTF-8">
  <title><?=addslashes($meta["title"][$url->lang]);?></title>
  <base href="<?=$url->baseUrl;?>" target="_self">
  <link rel="canonical" href="<?=$url->baseUrl.$url->virtualPath;?>">
  <link rel="author" type="text/plain" href="<?=$url->baseUrl;?>humans.txt" /><!-- http://humanstxt.org -->
  <meta name="lang" content="<?=$url->lang;?>">
  <meta name="generator" content="Your favourite code editor"><!-- https://stackoverflow.com/a/3632220 -->
  <meta name="robots" content="index, follow"><!-- https://developers.google.com/search/reference/robots_meta_tag -->
  <meta name="description" content="<?=addslashes($meta["description"][$url->lang]);?>"/>
  <meta name="keywords" content="<?=$meta["keywords"];?>"><!-- https://www.sistrix.es/blog/la-meta-keywords-un-bulo-con-19-anos-de-antiguedad/ -->
  <meta http-equiv="cache-control" content="no-cache"/>

<!-- DC (Dublin Core) https://www.dublincore.org/specifications/dublin-core/usageguide/2000-07-16/qualified-html/ -->
  <meta name = "DC.Title" content = "<?=addslashes($meta["title"][$url->lang]);?>">
  <meta name = "DC.Description.Abstract" content = "<?=addslashes($meta["description"][$url->lang]);?>">
  <meta name = "DC.Date.Created" content = "<?=$meta["date"];?>">
  <meta name = "DC.Language" content = "<?=$url->lang;?>">

<!-- OG (The Open Graph protocol) https://ogp.me/ -->
  <meta property="fb:app_id" content="123456789012345">
  <meta property="og:site_name" content="<?=addslashes($meta["siteName"][$url->lang]);?>">
  <meta property="og:type" content="article">
  <meta property="og:type" content="website --> <!=$url->virtualPath;?>">
  <meta property="og:url" content="<?=$url->baseUrl.$url->virtualPath;?>">
  <meta property="og:title" content="<?=addslashes($meta["title"][$url->lang]);?>">
  <meta property="og:description" content="<?=addslashes($meta["description"][$url->lang]);?>">
  <meta property="article:published_time" content="<?=$meta["date"];?>">
  <meta property="article:author" content="Name">
  <meta property="og:image" content="<?=(substr($meta["ogImageFile"],0,4)==="http" ? $meta["ogImageFile"] : $url->baseUrl.$meta["imgDir"].$meta["ogImageFile"]);?>">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="627">
  <meta property="og:image:alt" content="<?=addslashes($meta["ogImageAlt"][$url->lang]);?>">

<!-- Twitter Cards https://developer.twitter.com/en/docs/twitter-for-websites/cards/guides/getting-started -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?=addslashes($meta["title"][$url->lang]);?>">
  <meta name="twitter:image:alt" content="<?=addslashes($meta["ogImageAlt"][$url->lang]);?>">
  <meta name="twitter:site" content="<?=addslashes($meta["siteName"][$url->lang]);?>">

<!-- Geo Stuff https://geo-tag.de -->
  <meta name="geo.region" content="<?=$meta["geoRegion"];?>" />
  <meta name="geo.placename" content="<?=addslashes($meta["geoPlacement"][$url->lang]);?>" />
  <meta name="geo.position" content="<?=$meta["geoPositionLat"];?>;<?=$meta["geoPositionLon"];?>" />

<!-- Favicon https://favicon-generator.org -->
  <link rel="apple-touch-icon"      sizes="57x57"   href="<?=$url->baseUrl.$meta["imgDir"];?>favicon/apple-icon-57x57.png" />
  <link rel="apple-touch-icon"      sizes="60x60"   href="<?=$url->baseUrl.$meta["imgDir"];?>favicon/apple-icon-60x60.png" />
  <link rel="apple-touch-icon"      sizes="72x72"   href="<?=$url->baseUrl.$meta["imgDir"];?>favicon/apple-icon-72x72.png" />
  <link rel="apple-touch-icon"      sizes="76x76"   href="<?=$url->baseUrl.$meta["imgDir"];?>favicon/apple-icon-76x76.png" />
  <link rel="apple-touch-icon"      sizes="114x114" href="<?=$url->baseUrl.$meta["imgDir"];?>favicon/apple-icon-114x114.png" />
  <link rel="apple-touch-icon"      sizes="120x120" href="<?=$url->baseUrl.$meta["imgDir"];?>favicon/apple-icon-120x120.png" />
  <link rel="apple-touch-icon"      sizes="144x144" href="<?=$url->baseUrl.$meta["imgDir"];?>favicon/apple-icon-144x144.png" />
  <link rel="apple-touch-icon"      sizes="152x152" href="<?=$url->baseUrl.$meta["imgDir"];?>favicon/apple-icon-152x152.png" />
  <link rel="apple-touch-icon"      sizes="180x180" href="<?=$url->baseUrl.$meta["imgDir"];?>favicon/apple-icon-180x180.png" />
  <link rel="icon" type="image/png" sizes="192x192" href="<?=$url->baseUrl.$meta["imgDir"];?>favicon/android-icon-192x192.png" />
  <link rel="icon" type="image/png" sizes="32x32"   href="<?=$url->baseUrl.$meta["imgDir"];?>favicon/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="96x96"   href="<?=$url->baseUrl.$meta["imgDir"];?>favicon/favicon-96x96.png" />
  <link rel="icon" type="image/png" sizes="16x16"   href="<?=$url->baseUrl.$meta["imgDir"];?>favicon/favicon-16x16.png" />
  <link rel="manifest" href="<?=$url->baseUrl.$meta["imgDir"];?>favicon/manifest.json" />
  <meta name="msapplication-TileColor" content="#ffffff" />
  <meta name="msapplication-TileImage" content="<?=$url->baseUrl.$meta["imgDir"];?>favicon/ms-icon-144x144.png" />
  <meta name="theme-color" content="#ffffff" />

<!-- Custom CSS -->
  <link rel="stylesheet" href="<?=$meta["themesDir"].$meta["theme"];?>/styles.css<?="?".time();?>" />

</head>
<body>

<content>

  <header>

<?php

  require_once $meta["themesDir"].$meta["theme"]."/nav.php";

?>

  </header>

  <main>
