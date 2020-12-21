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



/* ------

  readHead

  Reads the header of the markdown files

------ */

function readHead($filepath) {

  $heads = [];
  $newHead = [];
  $metalines = ["[title]","[date]","[description]","[keywords]","[ogImageFile]","[ogImageAlt]"];
  $start = 0;
  $lines = 6;
  $file = new SplFileObject($filepath);
  $file->seek($start); // go to line $start
  for($i = 0; $i < $lines and $file->valid(); $i++, $file->next()) :
    $heads[] = html_entity_decode($file->current());
  endfor;

  foreach($heads as $head) : foreach ($metalines as $metaline) : if (stripos($head,$metaline) !== false) : endif; endforeach; endforeach;

  $metalines = str_replace(["[","]"],"",$metalines);
  foreach($heads as $head) :
    $head = explode(":",$head,2);
    if($head[0]!="" && substr($head[0],0,1)=="[") :
      $head[0] = trim($head[0]," [] ");
      $head[1] = trim($head[1]); $head[1] = trim($head[1],"()"); $head[1] = ltrim($head[1],"# "); $head[1] = trim($head[1],'"');
      if(in_array($head[0],["title","description","ogImageAlt"])) :
        $tit = $head[0];
        $head[1] = str_replace("|[",PHP_EOL."[",$head[1]);
        $tmp_head1 = explode(PHP_EOL,trim($head[1]));
        $tmp_head1 = str_replace("[","",$tmp_head1,$i);
        foreach($tmp_head1 as $tmp_head1Item):
          list($k,$v) = explode("]",$tmp_head1Item);
          $tmp_head1Items[$k] = $v;
        endforeach;
        $head[1] = $tmp_head1Items;
      endif;
      if(in_array($head[0],$metalines)) : $newHead[$head[0]] = $head[1]; endif;
    endif;
  endforeach;

  $file = null; // https://www.php.net/manual/es/class.splfileobject.php#113149
  return $newHead;

}
