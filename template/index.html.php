<?php ob_start()?>

<div class="bgded overlay" style="background-image:url('template/img/bg3.jpg');">
  <div id="pageintro" class="hoc clear">
    <div class="flexslider basicslider">
      <ul class="slides">
        <li>
          <article>
            <!--<p>Sit amet sodales non feugiat curabitur</p>-->
            <h3 class="heading">Spletna naročitev</h3>
            <p>Rezervirajte si datum preko spleta.</p>
            <footer>
              <ul class="nospace inline pushright">
                <li><a class="btn" href="index.php?stran=narociSe">Naroči se</a></li>
              </ul>
            </footer>
          </article>
        </li>
        <li>
          <article>
            <!--<p>Dignissim molestie neque ultricies vitae</p>-->
            <h3 class="heading">Objave uporabnikov</h3>
            <p>Dodaj svoj komentar ali mnenje o salonu.</p>
            <footer>
              <ul class="nospace inline pushright">
                <li><a class="btn" href="index.php?stran=objave">Objave</a></li>
              </ul>
            </footer>
          </article>
        </li>
        <li>
          <article>
            <!--<p>Ornare mi eget dictum orci nisi auctor turpis</p>-->
            <h3 class="heading">Diam convallis</h3>
            <p>Placerat et nisl in vulputate maecenas.</p>
            <footer>
              <ul class="nospace inline pushright">
                <li><a class="btn" href="index.php?stran=narociSe">Naroči se</a></li>
              </ul>
            </footer>
          </article>
        </li>
      </ul>
    </div>
  </div>
</div>

<div class="wrapper splitclrs">
  <div class="split clear">
    <div>
      <img src="template/img/strizenje.png" alt="strizenje">
    </div>
    <div>
      <h3 class="heading">Kako izbrati frizerja</h3>
      <p>Veliko je poklicev, ki so povezani z intimo posameznika, zato jih izbiramo s tehtnim premislekom. Zanimivo je eden od teh poklicev frizer. Je oseba, ki ji zaupamo in se ji prepustimo. Ko najdemo tistega pravega, ga težko izpustimo iz rok. Dober frizer je namreč oseba, ki ima rada delo z ljudmi, je odličen psiholog in kreativni arhitekt, ki glede na obliko obraza in glave ter vašo osebnost in stil izdela frizuro, ki poudari vašo lepoto. Dober frizer se nenehno izobražuje in spremlja modne trende, hkrati pa vas zna razvajati z dodatnimi storitvami in poskrbi za to, da so vaši lasje zdravi in lepi</p>
    </div>
  </div>
</div>


<div class="wrapper row3">
  <div class="hoc container clear">
    <div class="sectiontitle center">
      <h6 class="heading">Naše storitve</h6>
    </div>
    <div class="posts">
      <figure class="group">
        <div><img src="template/img/negaLas.jpg" alt="negaLas"></div>
        <figcaption>
          <i class="fa fa-check green"></i> <p class="inline-block">moško in žensko striženje</p><br>
          <i class="fa fa-check green"></i> <p class="inline-block">otroško in najstniško striženje</p><br>
          <i class="fa fa-check green"></i> <p class="inline-block">modno barvanje s permanentnimi barvami in prelivi</p><br>
          <i class="fa fa-check green"></i> <p class="inline-block">različne tehnike pramen</p><br>
          <i class="fa fa-check green"></i> <p class="inline-block">svetljenje las</p><br>
          <i class="fa fa-check green"></i> <p class="inline-block">nega las</p><br>
          <i class="fa fa-check green"></i> <p class="inline-block">trajno kodranje in ravnanje las</p>
          <!--<footer><a href="#" class="green">Preberi več &raquo;</a></footer>-->
        </figcaption>
      </figure>
      <figure class="group">
        <div><img src="template/img/uros.jpg" alt="uros"  style="width: 480px; height: 325px;"></div>
        <figcaption>
          <i class="fa fa-check green"></i> <p class="inline-block">kodranje in ravnanje las</p><br>
          <i class="fa fa-check green"></i> <p class="inline-block">obstojne fen pričeske</p><br>
          <i class="fa fa-check green"></i> <p class="inline-block">svečane pričeske in spletanje kitk</p><br>
          <i class="fa fa-check green"></i> <p class="inline-block">masaža lasišča</p><br>
          <i class="fa fa-check green"></i> <p class="inline-block">oblikovanje obrvi</p><br>
          <i class="fa fa-check green"></i> <p class="inline-block">barvanje obrvi in trepalnic</p><br>
          <i class="fa fa-check green"></i> <p class="inline-block">aromaterapija</p><br>
          <i class="fa fa-check green"></i> <p class="inline-block">britje glave</p>
          <!--<footer><a href="#" class="green">Preberi več &raquo;</a></footer>-->
        </figcaption>
      </figure>
    </div>
  </div>
</div>

<?php
$content=ob_get_clean();
require "template/layout.html.php";
?>
