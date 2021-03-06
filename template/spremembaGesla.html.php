<?php ob_start()?>

<h1 class="heading center topspace-80">Sprememba gesla</h1>
<div class="group" style="padding: 15px;">
  <div class="one_third first"><pre></pre></div>
  <div class="one_third">
    <form method="post" class="topspace-30 btmspace-80" id="myform">
      <input class="btmspace-15" type="password" placeholder="Trenutno geslo" required name="cpass" value="<?php if(isset($_POST['cpass'])){echo $_POST['cpass'];} ?>" id="cpass">
      <div class="group">
        <div class="one_half first">
          <input class="btmspace-15" type="password" placeholder="Novo geslo" name="pass" required value="<?php if(isset($_POST['pass'])){echo $_POST['pass'];} ?>" id="pass">
        </div>
        <div class="one_half">
          <input class="btmspace-15" type="password" placeholder="Ponovno vpišite novo geslo" name="pass2" required value="<?php if(isset($_POST['pass2'])){echo $_POST['pass2'];} ?>" id="pass2">
        </div>
      </div>
      <button class="btmspace-15" type="submit" name="submit">Spremeni geslo</button>
      <?php spremembaGesla(); ?>
    </form>
  </div>
</div>

<?php
$content=ob_get_clean();
require "template/layout.html.php";
?>
