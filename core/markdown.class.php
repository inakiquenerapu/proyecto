<?php

/* ------

  class Markdown

  Transforms Markdown file
  into feed for Parsedown

  Usage:

  $md = new Markdown($page,$urlLangs,$url->lang);

------ */

class Markdown {

  function __construct($file, $url) {

    /**
     *
     * @param string  $page               markdown file path + name
     * @param string  $this->file         the file itself
     * @param num     $this->headerLines  number of lines
     *
     */

    $this->headerLines      = 6;
    $this->urlLangs         = $url->urlLangs;
    $this->lang             = $url->lang;
    $this->dateFormat       = $url->langInfo["dateFormat"];
    $this->file             = fopen($file,"r") or die("Cannot read the file.");

    $this->headerMeta       = [];
    $this->page             = "";

    $this->headerToArray();
    $this->bodyToVar();
    $this->readLibraries();
    $this->markdown();

  }

  function __destruct() {

    /**
     *
     * Close everything you have opened.
     * Store everything you have used.
     * Turn off everything you have turned on.
     *
     * — Buddha (probably)
     *
     */

    fclose($this->file);

  }



  function headerToArray() {

    /**
     *
     * @param num     $num  blablabla
     * @param string  $var  blablabla
     *
     */

    $i=0;

    while((($line=fgets($this->file))!==false)&&($i++<$this->headerLines)):

      $this->headerMeta["tmp"][]=trim($line);

    endwhile;

//  echo "<pre>"; print_r($this->headerMeta); echo "</pre>";
//  die();

    $metalines = ["title","date","description","keywords","ogImageFile","ogImageAlt"];
    $metalinesWithLanguages = ["title","description","ogImageAlt"];

    foreach($this->headerMeta["tmp"] as $headerArrayLine) :
      $headerArrayLine = explode(":",$headerArrayLine,2);

      if($headerArrayLine[0]!="" && substr($headerArrayLine[0],0,1)=="[") :
         $headerArrayLine[0] = trim($headerArrayLine[0]," [] ");
         $headerArrayLine[1] = trim($headerArrayLine[1]);
         $headerArrayLine[1] = trim($headerArrayLine[1],"()");
         $headerArrayLine[1] = ltrim($headerArrayLine[1],"# ");
         $headerArrayLine[1] = trim($headerArrayLine[1],'"');
         $this->headerMeta["tmp"][$headerArrayLine[0]] = $headerArrayLine[1];

        // Maybe unnecessary, removes items numbered id. Warning: Includes numbers, a point and an `e` like in 1.1e10
        // foreach($this->headerMeta["tmp"] as $k=>$v) : if(is_numeric($k)) : unset($this->headerMeta["tmp"][$key]); endif; endforeach;

        if(in_array($headerArrayLine[0],$metalinesWithLanguages)) :
          ${$headerArrayLine[0]."s"} = explode("|",$this->headerMeta["tmp"][$headerArrayLine[0]]);
          foreach (${$headerArrayLine[0]."s"} as ${$headerArrayLine[0]}) :
            foreach ($this->urlLangs as $lang) :
              $lang = preg_match('#\[(.*?)\]#',${$headerArrayLine[0]},$lang) ? $lang[1] : $this->lang;
              $this->headerMeta[$headerArrayLine[0]][$lang] = preg_replace('/'.str_replace('/','\/','\['.$lang.'\]').'/','',${$headerArrayLine[0]},1);
            endforeach;
          endforeach;
        else :
          $this->headerMeta[$headerArrayLine[0]] = $headerArrayLine[1];
        endif;

      endif;
    endforeach;

    unset($this->headerMeta["tmp"]);

//  echo "<hr><pre>"; print_r($this->headerMeta); echo "</pre>";
//  die();

  }



  function bodyToVar() {

    /**
     *
     * @param num     $num  blablabla
     * @param string  $var  blablabla
     *
     */

    $i=0;

    while($line=fgets($this->file)) :

      $this->page.=$line; $i++;

    endwhile;

//  echo "<pre>".$this->page."</pre>";
//  die();

    $this->page = strstr($this->page,"[--");

    if(strpos($this->page,"[--".$this->lang."--]".PHP_EOL) !== false) :
              $this->page = strstr($this->page,"[--".$this->lang."--]".PHP_EOL);
              $this->page = strstr($this->page,"[--/".$this->lang."--]".PHP_EOL,true);
              $this->page = preg_replace('/\[\-\-'.$this->lang.'\-\-\]/','',$this->page,1);

  
    endif;

//  echo "<hr><pre>".$this->page."</pre>";
//  die();

  }



  function readLibraries() {

    /**
     *
     * Antes de hacer nada con markdown
     * aprenderemos Markdown.
     *
     * La casa recomienda Parsedown https://parsedown.org/
     *
     * @param string  $parsedownPath              path to Parsedown library
     * @param array   $parsedownLibraryFilesArray Parsedown file + extra + plugin
     *
     */

    $parsedownPath = "core/libraries/Parsedown/";

    $parsedownLibraryFilesArray = [
                                    "Parsedown.php",            # https://github.com/erusev/parsedown
                                    "ParsedownExtra.php",       # https://github.com/erusev/parsedown-extra
                                    "ParsedownExtraPlugin.php"  # https://github.com/taufik-nurrohman/parsedown-extra-plugin
                                  ];

    foreach($parsedownLibraryFilesArray as $lib) :

      require_once($parsedownPath.$lib);

    endforeach;

  }



  function markdown(){

    $this->preParseContent();
    $this->parseContent();
    $this->postParseContent();

  }



  function preParseContent(){

    /**
     *
     * @param num     $num  blablabla
     * @param string  $var  blablabla
     *
     */

    if(strpos($this->page,"<date>")    !==false) : $this->page = $this->filterDate($this->page);     endif;
    if(strpos($this->page,"<block>")   !==false) : $this->page = $this->filterBlock($this->page);    endif;
    if(strpos($this->page,"<videeo>")  !==false) : $this->page = $this->filterVideos($this->page);   endif;
    if(strpos($this->page,"<slides>")  !==false) : $this->page = $this->filterSlides($this->page);   endif;

  }



  function parseContent(){

    /**
     *
     * @param num     $num  blablabla
     * @param string  $var  blablabla
     *
     */

    $this->parsedown = new ParsedownExtraPlugin();
    $this->parsedown->code_block_attr_on_parent = true;
    $this->parsedown->code_text = '<span class="my-code">%s</span>';
    $this->parsedown->table_class = "table table-bordered table-condensed short";
    $this->page = $this->parsedown->text($this->page);

  }



  function postParseContent(){

    /**
     *
     * @param num     $num  blablabla
     * @param string  $var  blablabla
     *
     */

    if(strpos($this->page,"<p>--</p>") !==false) : $this->page = $this->filterIgnoreMe($this->page); endif;

  }



# ------------------------------------------



  function filterDate(){

    /**
     *
     * @param num     $num  blablabla
     * @param string  $var  blablabla
     *
     */

    $a = "<date>";
    $b = "<i class=\"far fa-calendar-alt\"></i> ";
//  $b = $this->langInfo["variant"];
    $b.= date($this->dateFormat,strtotime($this->headerMeta["date"]));
//  $b.= formattedDate($this->headerMeta["date"],$this->lang);
//  $b.= $this->headerMeta["date"];
    $this->page = str_replace($a,$b,$this->page);
    return $this->page;
  }



  function filterBlock(){

    /**
     *
     * @param num     $num  blablabla
     * @param string  $var  blablabla
     *
     */

    $a = ["<block>","</block>"];
    $b = ["<div class=\"block\" markdown=1>","</div>"];
    $this->page = str_replace($a,$b,$this->page);
    return $this->page;
  }



  function filterVideos(){

    /**
     *
     * @param num     $num  blablabla
     * @param string  $var  blablabla
     *
     */

    $a = ["<videeo>","</videeo>"];
    $b = ["<div class=\"video-responsive\">","</div>"];
    $youtubeUrls = ["youtube.com","youtu.be"];
    $vimeoUrls = ["vimeo.com"];
    $this->page = PHP_EOL.$this->page;
    $offset = 0;
    while(true):
      $ini = strpos($this->page,$a[0],$offset);
      if($ini == 0):break;endif;
      $ini += strlen($a[0]);
      $len = strpos($this->page,$a[1],$ini)-$ini;
      $oldVideo = substr($this->page,$ini,$len);
      foreach ($youtubeUrls as $url):
        if(strpos($oldVideo,$url)!==false):
          preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',$oldVideo,$match);
          // https://gist.github.com/ghalusa/6c7f3a00fd2383e5ef33
          $youtubeID = $match[1];
          $video = "<iframe id=\"ytplayer\" type=\"text/html\" src=\"https://www.youtube.com/embed/".$youtubeID."\" frameborder=\"0\" allowfullscreen></iframe>";
        endif;
      endforeach;
      foreach ($vimeoUrls as $url):
        if(strpos($oldVideo,$url)!==false):
          preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im',$oldVideo,$match);
          // https://gist.github.com/anjan011/1fcecdc236594e6d700f
          $vimeoID = $match[3];
          $video = "<iframe src=\"https://player.vimeo.com/video/".$vimeoID."\" frameborder=\"0\" allowfullscreen></iframe>";
        endif;
      endforeach;
      $this->page = str_replace($oldVideo,$video,$this->page);
      $offset = $ini+$len;
    endwhile;
    $this->page = str_replace($a,$b,$this->page);
    return $this->page;
  }



  function filterSlides(){

    /**
     *
     * @param num     $num  blablabla
     * @param string  $var  blablabla
     *
     */

    $a = ["<slides>","</slides>"];
    $b = ["<div class=\"slider sliderx\"><div class=\"slider-nav prev\">‹</div><div class=\"slider-thumbs\">","</div><div class=\"slider-nav next\">›</div></div>"];
    $s = "let sliderx=tns({'container':'.sliderx .slider-thumbs','nav':false,'controls':false,'gutter':20,'center':true,'arrowKeys':true,'responsive':{'900':{'items':2},'100':{'items': 1},},'slideBy':'page','mouseDrag':true,'swipeAngle':false,'speed':400,});document.querySelector('.sliderx .slider-nav.prev').onclick=function(){sliderx.goTo('prev');};document.querySelector('.sliderx .slider-nav.next').onclick=function(){sliderx.goTo('next');};let lightboxx=new SimpleLightbox('.sliderx .slider-thumbs a',{'history':false,'nav':true,'fileExt':'png|jpg|jpeg|php','enableKeyboard':false,'widthRatio':0.9,'captionDelay':500,'swipeClose':false,'showCounter':false,'docClose':false,});";
    $this->page = PHP_EOL.$this->page;
    $offset = 0;
    while(true):
      $ini = strpos($this->page,$a[0],$offset);
      if($ini == 0):break;endif;
      $ini += strlen($a[0]);
      $len = strpos($this->page,$a[1],$ini)-$ini;
      $oldSlide = substr($this->page,$ini,$len);
      $tmpSlide = explode(PHP_EOL,trim($oldSlide));
      $tmpSlide = array_combine(range(1,count($tmpSlide)),array_values($tmpSlide));
      $slide = "";
      foreach ($tmpSlide as $i=>$v):
        $slideRow = explode('|',$v);
        $slide.= "<div><a class=\"img\" href=\"img.php?img=img/".$slideRow[0]."\"><img src=\"img.php?img=img/".$slideRow[0]."\" alt=\"".trim($slideRow[1])."\" title=\"".trim($slideRow[1])."\"></a></div>";
      endforeach;
      $this->page = str_replace($oldSlide,$slide,$this->page);
      $offset = $ini+$len;
    endwhile;
    $this->page = str_replace($a,$b,$this->page);
    $i = 0;
    $v = "";
    while(strpos($this->page,"sliderx")!==false):
      $v.= str_replace(["sliderx","lightboxx"],["slider".$i,"lightbox".$i], $s);
      $this->page = preg_replace('/sliderx/','slider'.$i++,$this->page,1);
    endwhile;
    $this->page.= PHP_EOL.PHP_EOL.PHP_EOL."<script>".PHP_EOL.$v.PHP_EOL."</script>";
    return $this->page;
  }



  function filterIgnoreMe(){

    /**
     *
     * @param num     $num  blablabla
     * @param string  $var  blablabla
     *
     */

    $a = "<p>--</p>";
    $b = '<p class="ignore-me"></p>';
    $this->page = str_replace($a,$b,$this->page);
    return $this->page;
  }



}



?>