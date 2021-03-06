<?php ob_start()?>

  <div class="demo group">
    <div class="one_third first"><pre></pre></div>
    <div class="one_third btmspace-80">
        <h1 class="center heading topspace-80 btmspace-50">Dodaj objavo</h1>
        <form method="post" id="myform">
          <input type="text" name="naslov" value="<?php if(isset($_POST['naslov'])){echo $_POST['naslov'];} ?>" placeholder="Naslov objave" class="btmspace-15" maxlength="20" required>
          <textarea rows="4" name="vsebina" placeholder="Vsebina" class="btmspace-15" maxlength="200" required><?php if(isset($_POST['vsebina'])){echo $_POST['vsebina'];} ?></textarea>
          <button type="submit" name="objavi" class="btmspace-15">Objavi</button>
        </form>
        <p class="btmspace-80 left"><?php dodajObjavo(); ?></p>
    </div>
  </div>

<?php
$content=ob_get_clean();
require "template/layout.html.php";
?>
