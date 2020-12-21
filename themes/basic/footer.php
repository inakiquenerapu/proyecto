  </main>

</content>

<footer>

  <span id="login">
    <?= $login->isLogged() ?
        $links->item("Admin", "*admin") . " | " .
        $links->item("Logout", "*?logout") :
        $links->item("Login", "*login");
    ?>
  </span>

  Proyecto <?=$version;?>. <?=$url->langInfo["nativeName"];?>

</footer>

<?=isset($customJSforFooter)?$customJSforFooter:"";?>

</body>
</html>
