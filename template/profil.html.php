<?php
ob_start();
informacijeUporabnika();
?>

  <div class="demo group row3" style="padding: 15px;">
    <div class="one_quarter first">
      <pre></pre>
    </div>
    <div class="two_quarter topspace-80 btmspace-80">
      <h1 class="heading center">Profil</h1>
      <div class="wrapper row3">
        <main class="hoc container clear">
            <div id="comments">
              <form method="post">
                <div class="one_third first">
                  <label for="fname">Ime <span>*</span></label>
                  <input type="text" name="fname" id="fname" value="<?php echo $_SESSION['ime']; ?>" required>
                </div>
                <div class="one_third">
                  <label for="lname">Priimek <span>*</span></label>
                  <input type="text" name="lname" id="lname" value="<?php echo $_SESSION['priimek']; ?>" required>
                </div>
                <div class="one_third">
                  <label for="spol">Spol <span>*</span></label>
                  <input type="text" name="spol" id="spol" value="<?php echo $_SESSION['spol']; ?>" required>
                </div>
                <div class="one_half first">
                  <label for="username">Uporabniško ime <span>*</span></label>
                  <input type="text" name="username" id="username" value="<?php echo $_SESSION['upIme']; ?>" required>
                </div>
                <div class="one_half">
                  <label for="email">Email <span>*</span></label>
                  <input type="email" name="email" id="email" value="<?php echo $_SESSION['email']; ?>" required>
                </div>
                <input type="submit" name="submit" value="Update" class="inline-block"><a href="index.php?stran=spremembaGesla" class="lspace-10 inline-block">Želite spremeniti geslo?</a><br><br>
                <?php update(); ?>
              </form>
            </div>
          </div>
          <div class="clear"></div>
        </main>
      </div>
    </div>

<?php
unset($_SESSION['ime']);
unset($_SESSION['priimek']);
unset($_SESSION['username']);
unset($_SESSION['email']);
unset($_SESSION['spol']);
$content=ob_get_clean();
require "template/layout.html.php";
?>
