<?php ob_start(); ?>

<h1 class="heading center topspace-80">Prijava</h1>
<div class="demo group" style="padding: 15px;">
  <div class="one_third first"><pre></pre></div>
  <div class="one_third myform">
    <form method="post" class="topspace-30" id="myform">
      <input class="btmspace-15" type="text" placeholder="Uporabniško ime" required name="username" value="<?php if(isset($_POST['username'])){echo $_POST['username'];} ?>">
      <input class="btmspace-15" type="password" placeholder="Geslo" name="pass" required value="<?php if(isset($_POST['password'])){echo $_POST['password'];} ?>">
      <div class="group demo">
        <div class="one_third first">
          <input type="checkbox" name="ostaniPrijavljen" class="btmspace-15" id="ostaniPrijavljen">
          <label for="ostaniPrijavljen"><span>Zapomni si me</span></label>
          <div class="two_third"><pre></pre></div>
        </div>
      </div>
      <button class="btmspace-15 inline-block" type="submit" name="prijava">Prijava</button><a href="index.php?stran=pozabljenoGeslo" class="lspace-10 inline-block">Ste pozabili geslo?</a>
    </form>
    <p class="btmspace-80 left"><?php prijava(); ?></p>
  </div>
</div>

<script src='https://www.google.com/recaptcha/api.js'></script>

<?php
$content=ob_get_clean();
require "template/layout.html.php";
?>
