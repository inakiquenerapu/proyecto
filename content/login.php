<?php

  # SPECIAL PAGE
  # Visible ONLY when user IS NOT logged in

  if($login->isLogged()) :

    header("Location: ".$url->baseUrlLang);
    die();

  endif;

  if(
    isset($_POST["login-username"]) &&
    isset($_POST["login-password"])
    ) :

    $login->username = $_POST["login-username"];
    $login->password = $_POST["login-password"];
    $login->checkLoginForm();

    if(isset($login->fail)) : $_SESSION["loginFail"] = true; endif;

//  Post/Redirect/Get pattern: http://en.wikipedia.org/wiki/Post/Redirect/Get
    header("Location: {$_SERVER['REQUEST_URI']}", true, 303);
    die();

  endif;

//$headerMeta = require_once("genericHeaderMeta.php");

  $meta["title"] = [
    "en" => "Login page",
    "es" => "Página de ingreso",
    "gl" => "Páxina de ingreso",
  ];

  require_once $meta["themesDir"].$meta["theme"]."/header.php";
//require_once $meta["themesDir"].$meta["theme"]."/nav.php";

  $hi = [
    "en" => $meta["title"]["en"],
    "es" => $meta["title"]["es"],
    "gl" => $meta["title"]["gl"],
  ];

  $error = [
    "en" => "Error",
    "es" => "Error",
    "gl" => "Erro",
  ];

  $username = [
    "en"=> "Username",
    "es"=> "Usuario/a",
    "gl"=> "Usuario/a",
  ];

  $password = [
    "en"=> "Password",
    "es"=> "Contraseña",
    "gl"=> "Contrasinal",
  ];

  $enter = [
    "en" => "Enter",
    "es" => "Entrar",
    "gl" => "Entrar",
  ];

?>

<h1><?=$hi[$url->lang];?></h1>

<form id="login" method="post">

<?php if(isset($_SESSION["loginFail"])) : unset($_SESSION["loginFail"]); ?>
  <div class="alert">
    <?=$error[$url->lang];?>
  </div>
<?php endif; ?>

  <div class="row">
    <label for="login-username"><?=$username[$url->lang];?>:</label>
    <input type="text" id="login-username" name="login-username" value="" />
  </div>

  <div class="row">
    <label for="login-password"><?=$password[$url->lang];?>:</label>
    <input type="password" id="login-password" name="login-password" value="" />
  </div>

  <div class="row">
    <input type="submit" name="login" value="<?=$enter[$url->lang];?>" />
  </div>

</form>



<?php

  require_once $meta["themesDir"].$meta["theme"]."/footer.php";

?>
