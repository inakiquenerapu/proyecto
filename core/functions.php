<?php

/* ------

  array_remove_empty

  Cleans an array removing empty values
  e.g.:

------ */

function array_remove_empty($haystack) {

  foreach ($haystack as $key => $value) :

    if(is_array($value)) :

      $haystack[$key] = array_remove_empty($haystack[$key]);

    elseif(is_string($haystack[$key])) :

      $haystack[$key] = trim($value);

    endif;

    if(empty($haystack[$key])) :

      unset($haystack[$key]);

    endif;

  endforeach;

  if(!is_multiArray($haystack)) :

    $tmp_haystack = [];

    foreach ($haystack as $key => $value) :

      $tmp_haystack[$value] = $value;

    endforeach;

    $haystack = $tmp_haystack;

  endif;

  return $haystack;

  }



/* ------

  is_multiArray

  Checks if an array is bidimensional or not

------ */

function is_multiArray($a) {

  foreach($a as $v) : if(is_array($v)) : return true; endif; endforeach;

  return false;

  }



