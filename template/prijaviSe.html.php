<?php ob_start()?>

  <div class="center">
    <h1 class="heading center topspace-80">Niste prijavljeni!</h1>
    <br>
    <p class="center"><b>Če želite obiskati to spletno mesto <a href="index.php?stran=prijava">se prijavite!</a></b></p>
    <br><br>
    <i class="fa fa-exclamation-triangle xx btmspace-100"></i>
  </div>

<?php
$content=ob_get_clean();
require "template/layout.html.php";
?>
