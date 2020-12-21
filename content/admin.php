<?php

  # PRIVATE PAGE
  # Visible ONLY when user IS logged in

  if(!$login->isLogged()) :

    header("Location: ".$url->baseUrlLang.$meta["loginFile"]);
    die();

  endif;



  if(
         isset($_POST["fileName"])
      && isset($_POST["fileContent"])
    ) :

    if(file_exists($meta["contentDir"].$_POST["fileName"])) :

      if(is_writable($meta["contentDir"].$_POST["fileName"])) :

        $fileName = $_POST["fileName"];
        $fileContent = str_replace(["\r\n","\r","\n"], PHP_EOL, rtrim($_POST["fileContent"])).PHP_EOL;
        file_put_contents($meta["contentDir"].$fileName, htmlspecialchars($fileContent, ENT_NOQUOTES));
        header("Location: {$_SERVER['REQUEST_URI']}", true, 303);
        die();

      endif;

    endif;

  endif;



  $editMode = false;
  $edit = false;

  if(isset($url->virtualPathArray[1])) :

    if(file_exists($meta["contentDir"].$url->virtualPathArray[1].".md")) :

      $editMode = true;

      $edit = [
        "en"=> "Edit",
        "es"=> "Editando",
        "gl"=> "Editando",
      ];

    else :

      header("Location: ".$url->baseUrlLang.$meta["adminFile"]);
      die();

    endif;

  endif;



  $meta["title"] = [
    "en" => "Admin".($editMode ? " | <small>Editing ".$url->virtualPathArray[1].".md</small>" : ""),
    "es" => "Admin".($editMode ? " | <small>Editando ".$url->virtualPathArray[1].".md</small>" : ""),
    "gl" => "Admin".($editMode ? " | <small>Editando ".$url->virtualPathArray[1].".md</small>" : ""),
  ];


  $customJSforHeader = <<<EOD
  <script>
    /* whatever */
  </script>
EOD;

  $customJSforFooter = <<<EOD
<!-- CodeJar https://medv.io/codejar -->
  <script type="module" id="code">

    import {CodeJar} from "https://cdn.jsdelivr.net/npm/codejar@3.2.3/codejar.min.js"
    import {withLineNumbers} from "https://cdn.jsdelivr.net/npm/codejar@3.2.3/linenumbers.js"

    const jar = new CodeJar(
      document.querySelector(".editor"),
      withLineNumbers(Prism.highlightElement),
      Prism.highlightElement
    );

    const ele = document.forms["editFile"];

    if(document.forms["editFile"].addEventListener){

      document.forms["editFile"].addEventListener("submit", callback, false);

    }

    function callback(){

      document.getElementById("fileContent").value = jar.toString();
      jar.destroy();
      document.forms["editFile"].submit();

    }

  </script>

  <script src="https://cdn.jsdelivr.net/npm/prismjs@1.22.0/components/prism-core.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/prismjs@1.22.0/plugins/autoloader/prism-autoloader.min.js"></script>
EOD;

  $customCSSforHeader = <<<EOD
<!-- Prism.js https://prismjs.com -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.22.0/themes/prism-twilight.css" />
EOD;

  require_once $meta["themesDir"].$meta["theme"]."/header.php";

  $hi = [
    "en" => $meta["title"]["en"],
    "es" => $meta["title"]["es"],
    "gl" => $meta["title"]["gl"],
  ];

?>

<h1><?=$hi[$url->lang];?></h1>

<?php

  if($editMode) :

    $update = [
      "en"=> "Update",
      "es"=> "Actualizar",
      "gl"=> "Actualizar",
    ];

    $fileContent = file_get_contents($meta["contentDir"].$url->virtualPathArray[1].".md");

?>

<form id="editFile" method="post">

  <div class="row">
    <input type="hidden" name="fileName" id="fileName" value="<?=$url->virtualPathArray[1];?>.md">
    <div style="width:100%;">
      <div id="editor" class="editor language-md" data-gramm="false"><?=file_get_contents($meta["contentDir"].$url->virtualPathArray[1].".md");?></div>
      <textarea name="fileContent" id="fileContent" class="hidden"></textarea>
    </div>
  </div>
  <div class="row">
    <input type="submit" name="send" value="<?=$update[$url->lang];?>" />
  </div>

</form>

<?php

  else :

    $txt = [
      "en" => "The place where you can edit your markdown files.",
      "es" => "El lugar donde puedes editar tus archivos markdown.",
      "gl" => "O lugar onde podes editar os teus arquivos markdown.",
    ];

?>

    <p><?=$txt[$url->lang];?></p>

<?php

    $timeToRefresh = time()-1*60;
    $justCreated = false;

    if(!file_exists($meta["contentDir"].$meta["filesFile"])):

      touch($meta["contentDir"].$meta["filesFile"]);
      $justCreated = true;

    endif;

    if(
        is_writable($meta["contentDir"].$meta["filesFile"]) &&
        ($justCreated || filemtime($meta["contentDir"].$meta["filesFile"]) < $timeToRefresh)
      ) :

      $ff = glob($meta["contentDir"]."*.md");

      if(count($ff)>0):

        $i = 0;

        foreach($ff as $f):

          $filePath=explode("/",$f);
          $fileName = end($filePath);
          $fileUrl = pathinfo($fileName,PATHINFO_FILENAME);

          $jsonMeta[$i] = readHead($f);
          $jsonMeta[$i] =

          [

                  "url"  =>  $fileUrl,
                "title"  =>  [
                               "en" => $jsonMeta[$i]["title"]["en"],
                               "es" => $jsonMeta[$i]["title"]["es"],
                               "gl" => $jsonMeta[$i]["title"]["gl"],
                             ],
                 "date"  =>  $jsonMeta[$i]["date"],

          ];

          $i++;

        endforeach;

        usort($jsonMeta,function($a,$b){return $b['date'] <=> $a['date'];});
        file_put_contents($meta["contentDir"].$meta["filesFile"],json_encode($jsonMeta, JSON_PRETTY_PRINT, FILE_APPEND | LOCK_EX));

      else :

        unlink($meta["contentDir"].$meta["filesFile"]);

      endif;

    endif;


    $files = file_get_contents($meta["contentDir"].$meta["filesFile"]);
    $files = json_decode($files, true);

    if(isset($files) && count($files)>0) :

      echo "<ul>";
      $i = 0;

      while($i < count($files)) :

        echo "<li><a href=\"".$url->baseUrlLang.$url->virtualPathArray[0]."/".$files[$i]["url"]."\">".$files[$i]["url"]."</a></li>";
        $i++;

      endwhile;

      echo "</ul>";

    endif;

  endif;



  require_once $meta["themesDir"].$meta["theme"]."/footer.php";

?>
