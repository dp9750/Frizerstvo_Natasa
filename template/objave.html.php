<?php ob_start()?>

  <div class="demo group row3">
    <div class="one_quarter first"><pre></pre></div>
    <div class="two_quarter">
      <div class="elementsInline center btmspace-80">
        <h1 class="center topspace-80 heading">Objave</h1><a class="btn inline-block fl_right topspace-80" href="index.php?stran=dodajObjavo"><i class="fa fa-plus"></i> Dodaj objavo</a>
      </div>
      <div class="btmspace-80">
        <div id="comments">
          <ul>
            <?php izpisObjav(); ?>
          </ul>
        </div>
      </div>
    </div>
  </div>

<?php
$content=ob_get_clean();
require "template/layout.html.php";
?>
