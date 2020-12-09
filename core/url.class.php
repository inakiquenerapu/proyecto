<?php

/* ------

  class Url

  Gets info from the url

  Usage:

  $url = new Url(dirname($_SERVER["PHP_SELF"]));

------ */

class Url {

  function __construct($self) {

    $this->langs = [ # Option one: there's only one language. URL won't show it.
      "gl",
    ];

    $this->langs = [ # Option two: there are more than one language. URL changes accordingly.
      "en",
      "es",
      "gl",
    ];

    $this->langs = [ # Option three: there are more than one language and grouped sub-languages. URL changes accordingly.
      "en"=>["en"],
      "es"=>["es","as","ct","eu"],
      "gl"=>["gl"],
    ];
/*
*/
    $this->langs = !isset($this->langs) ? [] : array_remove_empty($this->langs);
    if(!isset($this->langs) || count($this->langs)==0 || (is_multiArray($this->langs) && count($this->langs)==1)): die("Wrong language options. Bye."); endif;

    $this->lang               = false;
    $this->urlLangs           = array_keys($this->langs);
    $this->multilingual       = count($this->urlLangs)==1 ? false : true ;
    $this->browserLang        = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2);
    $this->scheme             = "http".(isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"]!=="off" ? "s" : "");
    $this->domain             = $_SERVER["SERVER_NAME"];
    $this->port               = !in_array($_SERVER["SERVER_PORT"],[80,443]) ? $_SERVER["SERVER_PORT"] : false;
    $this->host               = $this->domain.($this->port ? ":".$this->port : "");
    $this->realPath           = (substr($self,-1)=="/" ? $self : $self."/");
    $this->path               = $_SERVER["REDIRECT_URL"] ?? $this->realPath;
//  $this->path               = isset($_SERVER["REDIRECT_URL"]) ? $_SERVER["REDIRECT_URL"] : $this->realPath; // PHP < 7
    $this->baseUrl            = $this->scheme."://".$this->host.$this->realPath;
    $this->virtualPath        = preg_replace('/'.str_replace('/','\/',$this->realPath).'/','',$this->path,1);
    $this->virtualPathArray   = array_values(array_filter(explode("/",$this->virtualPath)));

    if(!$this->multilingual) :

      $this->lang = array_key_first($this->langs);

    else :

      if(
            (!is_multiArray($this->langs) && (isset($this->virtualPathArray[0]) && in_array($this->virtualPathArray[0],array_values($this->langs))))
         || ( is_multiArray($this->langs) && (isset($this->virtualPathArray[0]) && in_array($this->virtualPathArray[0],  array_keys($this->langs))))
        ) :

//      Main language found!
        $this->lang = array_shift($this->virtualPathArray);

      else :

//      Main language NOT found! Looking within the sub-languages
        foreach($this->langs as $k=>$v):

          if(is_array($v) && $v!="" && (isset($this->virtualPathArray[0]) && in_array($this->virtualPathArray[0],$v))) :

            array_shift($this->virtualPathArray);
            $this->lang = $k;
            $this->reload(); # Secondary language found! Reloading page.

          endif;

        endforeach;

      endif;

      if(!$this->lang) :

//      Language NOT found nor in main nor in secondary languages array! Realoading using last/first (your choice!) language of the array

        if (!function_exists("array_key_first")) : # For PHP > 4.0 && PHP < 7.3.0

          $this->lang = is_multiArray($this->langs) ? array_keys($this->langs) : array_values($this->langs);
          $this->lang = reset($this->lang); # FIRST!
//        $this->lang = end($this->lang);   # LAST!

        else :

          $this->lang = is_multiArray($this->langs) ? array_key_first($this->langs) : reset($this->langs); # FIRST!
//        $this->lang = is_multiArray($this->langs) ? array_key_last($this->langs) : end($this->langs);    # LAST!

        endif;

        $this->reload();

      endif;

    endif;

    $this->virtualPathNoLang  = $this->multilingual ? preg_replace('/'.str_replace('/','\/',$this->lang).'/','',$this->virtualPath,1) : $this->virtualPath;

    $langsJson = file_get_contents("langs.json");
    $langsJson = json_decode($langsJson,true);
    $code = array_search($this->lang, array_column($langsJson, "code"));
    $this->langInfo = $langsJson[$code];

  }



  function reload() {

    header(
          "location: ".
          $this->baseUrl.
          $this->lang."/".
          implode("/",$this->virtualPathArray).
          ($this->query != "" ? "/?".$this->query : "")
          );
    die();

  }

}