<?php ob_start(); ?>

    <h1 class="heading center topspace-80">Registracija</h1>
    <div class="group demo" style="padding: 15px;">
      <div class="one_third first"><pre></pre></div>
      <div class="one_third myform">
        <form method="post" class="topspace-30" id="myform">
          <div class="group demo">
            <div class="one_half first"><input class="btmspace-15" type="text" placeholder="Ime" required name="fname" id="fname" value="<?php if(isset($_POST['fname'])){echo $_POST['fname'];} ?>"></div>
            <div class="one_half"><input class="btmspace-15" type="text" placeholder="Priimek" required name="lname" value="<?php if(isset($_POST['lname'])){echo $_POST['lname'];} ?>"></div>
          </div>
          <div class="group demo">
              <div class="two_third first">
                <input class="btmspace-15" type="text" placeholder="Uporabniško ime" required name="username" value="<?php if(isset($_POST['username'])){echo $_POST['username'];} ?>">
              </div>
              <div class="one_third">
                <input type="radio" id="moski" value="moski" name="spol">
                <label for="moski"><span>Moški</span></label>
                <input type="radio" id="zenska" value="zenska" name="spol">
                <label for="zenska"><span>Ženska</span></label>
              </div>
          </div>
          <input class="btmspace-15" type="email" placeholder="Email" required name="email" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>">
          <div class="group demo">
            <div class="one_half first"><input class="btmspace-15" type="password" placeholder="Geslo" name="pass1" required></div>
            <div class="one_half"><input class="btmspace-15" type="password" placeholder="Ponovi geslo" name="pass2" required></div>
          </div>
          <div class='g-recaptcha btmspace-15' data-sitekey='6Lcd10YUAAAAAAuNrWmNjZJ1x3TO3w5TKLy0a_2R' data-theme='dark'></div>
          <button type="submit" name="register" class="btmspace-80">Registracija</button>
        </form>
        <p class="btmspace-80 left"><?php registracija(); ?></p>
      </div>
  </div>

    <script src='https://www.google.com/recaptcha/api.js'></script>

<?php
$content=ob_get_clean();
require "template/layout.html.php";
?>
