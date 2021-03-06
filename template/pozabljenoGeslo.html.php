<?php ob_start()?>

<h1 class="heading center topspace-80" style="padding: 15px;">Pozabljeno geslo</h1>
<div class="demo group">
  <div class="one_third first"><pre></pre></div>
  <div class="one_third myform">
    <form method="post" class="topspace-30"  id="myform">
      <input class="btmspace-15" type="text" placeholder="Uporabniško ime" required name="username" value="<?php if(isset($_POST['username'])){echo $_POST['username'];} ?>">
      <input class="btmspace-15" type="email" placeholder="Email" name="email" required value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>">
      <button class="btmspace-15" type="submit" name="pozabljenoGeslo">Novo geslo</button>
    </form>
    <p class="btmspace-80"><?php pozabljenoGeslo(); ?></p>
  </div>
</div>

<?php
$content=ob_get_clean();
require "template/layout.html.php";
?>
