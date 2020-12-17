  </main>

</content>

<footer>

  <span id="login">
    <?= $login->isLogged() ?
        $links->item("Logout", "*?logout") :
        $links->item("Login", "*login");
    ?>
  </span>

  Proyecto <?=$version;?>. <?=$url->langInfo["nativeName"];?>

</footer>

</body>
</html>
