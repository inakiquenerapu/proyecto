<?php

/* ------

  class Links

  Builds link lists

  Usage:

  $links = new Links();

  
  $links->item("Text","slug", "p", "id", "class"); //Only first argument is mandatory
  $links->item("Text","!slug", "p", "id", "class"); // Exclamation mark forces target="_blank" or class="selected" as appropriate
  
  $links->item("🏠");
  $links->item("Home");
  $links->item("El País", "!https://elpais.com");
  $links->item("El País", "!https://elpais.com", "div");
  $links->item("Microsiervos","https://microsiervos.com", "p", "link-id", "link-class");
  $links->item("📯","contact", "span");
  $links->item("📌","!about", "p", "about-id", "about-class");

  $links->langs($array_of_languages, "ul|li"); // Only first argument is mandatory
  $links->langs($url->langs);
  $links->langs($url->langs, "p|span");

  $links->list($array_of_links, "ul|li"); // Only first argument is mandatory
  $links->list($meta["navLinks"]);
  $links->list($meta["navLinks"], "p|span");

------ */

class Links {

  function __construct($baseUrl, $multilingual, $lang, $page, $virtualPathNoLang, $query) {

    $this->baseUrl            = $baseUrl;
    $this->multilingual       = $multilingual;
    $this->lang               = $lang;
    $this->page               = $page;
    $this->virtualPathNoLang  = $virtualPathNoLang;
    $this->query              = $query;

  }



  function item($title, $slug=false, $tag=false, $id=false, $class=false) {

    $this->isIndependent = !isset($this->isLang) ?? false;
    $noMoreVirtualPath = !$this->isIndependent && substr($slug,0,1) === "*" ?? false;
    $slug = substr($slug,0,1) === "*" ? ltrim($slug,"*") : $slug;
    $selected = !$this->isIndependent && $tag && substr($slug,0,1) === "!" ?? false;
    $targetBlank = $this->isIndependent && substr($slug,0,1) === "!" ?? false;
    $slug = substr($slug,0,1) === "!" ? ltrim($slug,"!") : $slug;
    $externalLink = substr($slug,0,4) === "http" ?? false;
  
    $stuff =
             (!$selected ? '<a href="' : "").
             (!$externalLink ? 
               (!$selected ? $this->baseUrl : "").
               (!$selected ? 
                 (isset($this->isLang) && !$this->isLang ? 
                       ($this->multilingual?$this->lang."/".($slug??""):($slug??"")) :
                       ($this->isIndependent ? 
                         ($this->multilingual?$this->lang."/".($slug??""):($slug??"")) :
                         (!$noMoreVirtualPath ? ($slug??"") : "")
                       ).(!$noMoreVirtualPath ? $this->virtualPathNoLang : ($slug??""))
                 )
                 : ""
               ).
               (!$selected ? ($slug!="?logout" && $this->query!="" ? "?".$this->query : "") : "")
               : $slug
             ).
             (!$selected ? '"'.($targetBlank ? ' target="_blank" rel="noopener noreferrer nofollow"' : "").'>' : "").
             ($tag?"<".$tag.
               (!$id ? "" : ' id="'.$id.'"').
               ($selected || $class ? ' class="'.($selected ? "selected" : "").($class ? ($selected ? " " : "").$class : "").'"' : "").
             ">"
             :"").
               $title.
             ($tag?"</".$tag.">":"").
             (!$selected ? "</a>" : "");

      return $stuff;

  }



  function list($items, $tag="ul|li") {
  
    $this->isLang = false;

    $tag = explode("|",$tag);
    $childTag = isset($tag[1])?$tag[1]:false;
    $parentTag = $tag[0];
    $stuff = "<".$parentTag.">";

    foreach($items as $i=>$v) :
  
      $stuff.=
        $this->item(
                    $v[$this->lang],
                    ($i === $this->page || (!$this->page && $i === "home") ? "!" : "").($i !== "home" ? $i : ""),
                    $childTag,
                   );

    endforeach;

    $stuff.= "</".$parentTag.">";

    return $stuff;
  
  }



  function langs($items, $tag="ul|li") {
  
    $this->isLang = true;

    if($this->multilingual) :

      $tag = explode("|",$tag);
      $childTag = isset($tag[1])?$tag[1]:false;
      $parentTag = $tag[0];
      $stuff = "<".$parentTag.">";

      foreach($items as $i=>$v) :

        $stuff.=
          $this->item(
                      mb_strtoupper($i,"UTF-8"),
                      ($i === $this->lang ? "!" : "").$i,
                      $childTag,
                     );

      endforeach;

      $stuff.= "</".$parentTag.">";

      return $stuff;

    endif;
  
  }

}
