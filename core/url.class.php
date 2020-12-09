<?php

class Url {

  function __construct($self) {

    $this->langs = ["en","es","gl"];
    $this->lang = $this->langs[0];
    $this->multilingual = count($this->langs) > 1 ? true : false ;
    $this->realPath = $self;
    $this->path = $_SERVER["REDIRECT_URL"] ?? $this->realPath;
    $this->virtualPath = preg_replace('/'.str_replace('/','\/',$this->realPath).'/','',$this->path,1);
    $this->virtualPathNoLang = $this->virtualPath;
    $this->virtualPathArray = array_values(array_filter(explode("/",$this->virtualPath)));
    $this->virtualPathNoLangArray = $this->virtualPathArray;

    if($this->multilingual) {

      if(isset($this->virtualPathArray[0])) {

        if(in_array($this->virtualPathArray[0],$this->langs)) {

          $this->virtualPathNoLangArray = array_slice($this->virtualPathArray,1);
          $this->virtualPathNoLang = implode("/",$this->virtualPathNoLangArray);
          $this->lang = $this->virtualPathArray[0];

        } else {

          header("Location: " . $this->realPath . "/". $this->lang . $this->virtualPathNoLang); die();
    
        }

      } else {

        header("Location: " . $this->realPath . "/". $this->lang); die();

      }

    }

  }

}

?>