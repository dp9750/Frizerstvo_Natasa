<!DOCTYPE html>
<html lang="sl">
<head>
<title>Frizerstvo Nataša</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="template/layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top">

  <div class="wrapper row0">
    <div id="topbar" class="hoc clear">
      <div class="fl_left">
        <ul>
          <li><i class="fa fa-phone"></i> +386 31 312 142</li>
        </ul>
      </div>
      <div class="fl_right">
        <ul>
          <li><a href="index.php"><i class="fa fa-lg fa-home"></i></a></li>
          <?php
          if(isset($_SESSION['upIme'])) {
            echo "<li><a href='index.php?stran=odjava'><i class='fa fa-lg fa-sign-out'></i>Odjava</a></li>";
          } else {
            echo "<li><a href='index.php?stran=prijava'>Prijava</a></li>";
            echo "<li><a href='index.php?stran=registracija'>Registracija</a></li>";
          }
           ?>
        </ul>
      </div>
    </div>
  </div>

  <div class="wrapper row1">
    <header id="header" class="hoc clear">
      <h1><a href="index.php">Frizerstvo Nataša</a></h1>
    </header>
  </div>

  <div class="wrapper row4">
    <nav id="mainav" class="hoc clear">
      <ul class="clear">
        <li><a href="index.php">Domov</a></li> <!--  class="active" -->
        <li><a href="index.php?stran=narociSe">Naroci se</a></li>
        <li><a href="index.php?stran=objave">Objave</a></li>
        <?php if(isset($_SESSION['upIme'])){echo "<li><a href='index.php?stran=profil'>Profil</a></li>";} ?>
        <li><a href="index.php?stran=kontakt">Kontakt</a></li>
      </ul>
    </nav>
  </div>

    <?php
      echo $content;
    ?>

    <div class="wrapper row4">
      <footer id="footer" class="hoc clear">
        <div class="group btmspace-50">
          <div class="one_third first">
            <h6 class="heading">Kontakt</h6>
            <ul class="nospace btmspace-30 linklist contact">
              <li><i class="fa fa-map-marker"></i>
                <address>Gozdna ulica 3, 9241 Veržej</address>
              </li>
              <li><i class="fa fa-phone"></i> +386 31 312 142</li>
              <li><i class="fa fa-fax"></i> +386 (031) 312 142</li>
            </ul>
          </div>
          <div class="one_third">
            <article>
              <h6 class="heading">Delovni čas</h6>
              <ul class="nospace linklist">
                <li>
                  <p class="nospace">PONEDELJEK - Zaprto</p>
                  <p class="nospace">TOREK - 08:00 - 17:00</p>
                  <p class="nospace">SREDA - 10:00 - 18:00</p>
                  <p class="nospace">ČETRTEK - 08:00 - 16:00</p>
                  <p class="nospace">PETEK - 08:00 - 17:00</p>
                  <p class="nospace">SOBOTA - 07:00 - 13:00</p>
                  <p class="nospace">NEDELJA - Zaprto</p>
                </li>
              </ul>
            </article>
          </div>
          <div class="one_third">
            <h6 class="heading">Pošlji sporočilo</h6>
            <form method="post">
              <input class="btmspace-15" type="text" placeholder="Ime" name="ime">
              <input class="btmspace-15" type="email" placeholder="Email" name="posta">
              <textarea class="btmspace-15" rows="3" cols="80" placeholder="Sporočilo" name="sporocilo"></textarea>
              <button type="submit" name="posljiSporocilo" class="btmspace-15">Pošlji</button>
              <?php kontaktiraj(); ?>
            </form>
          </div>
        </div>
      </footer>
    </div>

    <div class="wrapper row5">
      <div id="copyright" class="hoc clear">
        <p class="fl_left">Copyright &copy; 2018 - Denis Prelog</p>
      </div>
    </div>

    <script src="template/layout/scripts/jquery.min.js"></script>
    <script src="template/layout/scripts/jquery.mobilemenu.js"></script>
    <script src="template/layout/scripts/jquery.flexslider-min.js"></script>
  </body>
</html>
