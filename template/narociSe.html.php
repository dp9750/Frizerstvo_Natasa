<?php ob_start();

date_default_timezone_set('Europe/Ljubljana');

// prejšnji in naslednji mesec
if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    $ym = date('Y-m'); // ta mesec
}

$timestamp = strtotime($ym . '-01');
if ($timestamp === false) {
    $timestamp = time();
}

$today = date('Y-m-j', time()); // danes

$html_title = date('Y / m', $timestamp);

// Link za prejšnji in nasledji mesec     mktime(hour,minute,second,month,day,year)
$prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));
$next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));

// St. dni v mescu
$day_count = date('t', $timestamp);

// 0:Ned 1:Pon 2:Tor ...
$str = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));


// Ustvari kolendar
$weeks = array();
$week = '';

// Prazne celice
$week .= str_repeat('<td></td>', $str);

for ( $day = 1; $day <= $day_count; $day++, $str++) {

    $date = $ym.'-'.$day;

    if(isset($_SESSION['upIme'])){

      $link=open_database_connection();

      $username = $_SESSION['upIme'];
      $sql="SELECT id FROM uporabnik WHERE username='$username';";
      $result =  mysqli_query($link, $sql);
    	$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
    	$id_uporabnika = $row['id'];

      $sql = "SELECT * FROM narocitve WHERE idUp='$id_uporabnika' AND zasedenDatum='$date';";
    	$rezultat =  mysqli_query($link, $sql);
    	$row=mysqli_fetch_array($rezultat,MYSQLI_ASSOC);
    	$rezerviranDatum = $row['zasedenDatum'];

      $sql1 = "SELECT * FROM narocitve WHERE NOT idUp='$id_uporabnika' AND zasedenDatum='$date';";
      $rezultat1 =  mysqli_query($link, $sql1);
    	$row1=mysqli_fetch_array($rezultat1,MYSQLI_ASSOC);
    	$zasedeno = $row1['zasedenDatum'];

      if($today == $date) {
        $week .= '<td class="today">'.$day;
      } else if($date == $rezerviranDatum) {
        $week .= '<td class="reserved">'.$day;
      } else if($date == $zasedeno) {
        $week .= '<td class="denied">'.$day;
      } else {
        $week .= "<td><a href='index.php?stran=narociSe&date=".$date."'>".$day."</a>";
      }
      $week .= '</td>';

      close_database_connection($link);

    } else {

      $link=open_database_connection();
      $sql = "SELECT * FROM narocitve WHERE zasedenDatum='$date'";
    	$rezultat =  mysqli_query($link, $sql);
    	$row=mysqli_fetch_array($rezultat,MYSQLI_ASSOC);
    	$datum = $row['zasedenDatum'];

      if($today == $date) {
        $week .= '<td class="today">'.$day;
      } else if($date == $datum) {
        $week .= '<td class="denied">'.$day;
      } else {
        $week .= "<td><a href='index.php?stran=narociSe&date=".$date."'>".$day."</a>";
      }
      $week .= '</td>';
      close_database_connection($link);
    }

    // Konec tedna ali konec mesca
    if ($str % 7 == 6 || $day == $day_count) {
      if($day == $day_count) {
        $week .= str_repeat('<td class="empty"></td>', 6 - ($str % 7)); // prazna celica
      }
      $weeks[] = '<tr>'.$week.'</tr>';
      $week = ''; // Pripravi za naslednji teden
    }
}
?>
  <table>
   <tr>
     <th>N</th>
     <th>P</th>
     <th>T</th>
     <th>S</th>
     <th>Č</th>
     <th>P</th>
     <th>S</th>
   </tr>
   <?php
     foreach ($weeks as $week) {
        echo $week;
     }
   ?>
  </table>
  <br>

  <div class="group btmspace-80" style="padding: 15px;">
    <div class="one_quarter first"><pre></pre></div>
    <div class="two_quarter">
      <h3 class="heading topspace-50 btmspace-50"><a href="index.php?stran=narociSe&ym=<?php echo $prev; ?>">&lt;</a> <?php echo $html_title; ?> <a href="index.php?stran=narociSe&ym=<?php echo $next; ?>">&gt;</a></h3>
      <div class="one_third first">
        <div id="colorLegend">
          <div class="inspace-5 bggrey"><pre></pre></div><p class="inline-block">Zaprto</p><br><br>
          <div class="inspace-5 bgorange"><pre></pre></div><p class="inline-block">Današnji dan</p>
        </div>
      </div>
      <div class="one_third">
        <div id="colorLegend">
          <div class="inspace-5 bgred"><pre></pre></div><p class="inline-block">Ni možno</p><br><br>
          <div class="inspace-5 bggreen"><pre></pre></div><p class="inline-block">Rezervirano</p>
        </div>
      </div>
      <div class="one_third">
        <p class="nospace left">Kliknite na okvirček z željenim datumom. <br><br>Rezervacija je potrebna najmanj en dan prej.</p>
      </div>
    </div>
  </div>

  <div class="group row3 topspace-80" style="padding: 15px;">
    <h1 class="heading center btmspace-50 topspace-80" id="narociSeHeader">Naroči se</h1>
    <div class="one_quarter first">
      <pre></pre>
    </div>
    <div class="two_quarter btmspace-80">
      <div id="comments">
        <form method="post" action="#colorLegend">
          <div class="one_third first">
            <label for="name">Ime in priimek<span>*</span></label>
            <input type="text" name="name" id="name" value="<?php if(isset($_POST['name'])){ echo $_POST['name'];} ?>" required>
          </div>
          <div class="one_third">
            <label for="date">Datum <span>*</span></label>
            <input type="text" name="datum" id="date" value="<?php if(isset($_GET['date'])){ echo $_GET['date'];} ?>" required disabled placeholder="Izberite datum">
          </div>
          <div class="one_third">
            <label for="spol">Spol <span>*</span></label>
            <input type="text" name="spol" id="spol" value="<?php if(isset($_POST['spol'])){ echo $_POST['spol'];} ?>" required placeholder="moski/zenski">
          </div>
          <label for="email">Email <span>*</span></label>
          <input type="email" name="email" id="email" value="<?php if(isset($_POST['email'])){ echo $_POST['email'];} ?>" class="btmspace-15" required>
          <input type="submit" name="submit" value="Naroči se"><br><br>
          <?php narociSe(); ?>
        </form>
      </div>
    </div>
  </div>

  <script>
  var errors = "<?php if(isset($_GET['date'])){echo 'scrollDown';} ?>";
  if (errors) {
      document.getElementById("narociSeHeader").scrollIntoView();
  }
  </script>

<?php
$content=ob_get_clean();
require "template/layout.html.php";
?>
