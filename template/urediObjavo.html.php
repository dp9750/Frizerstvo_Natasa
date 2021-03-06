<?php
  ob_start();
  izpisObjaveUredi();
?>

<div class="demo group row3">
  <div class="one_quarter first"><pre></pre></div>
  <div class="two_quarter">
    <div class="center btmspace-80">
      <h1 class="center topspace-80 heading">Uredi objavo</h1>
    </div>
      <div id="comments">
        <form method="post" class="btmspace-80">
          <div class="one_third first">
            <label for="name">Objavo dodal: <span>*</span></label>
            <input type="text" name="name" id="name" value="<?php echo $_SESSION['imeUpTmpObjave']; ?>" required disabled placeholder="Uporabnik">
          </div>
          <div class="two_third">
            <label for="naslov">Naslov <span>*</span></label>
            <input type="text" name="naslov" id="naslov" value="<?php echo $_SESSION['naslovTmpObjave']; ?>" required placeholder="Naslov objave">
          </div>
          <label for="vsebina">Vsebina <span>*</span></label>
          <textarea type="email" name="vsebina" id="vsebina" class="btmspace-15" required maxlength="200" rows="8" placeholder="Vsebina objave"><?php echo $_SESSION['vsebinaTmpObjave']; ?></textarea>
          <input type="submit" name="submit" value="Zaključi urejanje"><br><br>
          <?php urediObjavo(); ?>
        </form>
      </div>
  </div>
</div>

<?php
unset($_SESSION['imeUpTmpObjave']);
unset($_SESSION['naslovTmpObjave']);
unset($_SESSION['vsebinaTmpObjave']);
$content=ob_get_clean();
require "template/layout.html.php";
?>
