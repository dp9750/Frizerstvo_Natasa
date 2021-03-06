<?php
function registracija() {
	function post_captcha($user_response) {
				$fields_string = '';
				$fields = array(
						'secret' => '6Lcd10YUAAAAAMNK5-zeXz0XYA8eVZqHMSA-3tu_',
						'response' => $user_response
				);
				foreach($fields as $key=>$value)
				$fields_string .= $key . '=' . $value . '&';
				$fields_string = rtrim($fields_string, '&');

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
				curl_setopt($ch, CURLOPT_POST, count($fields));
				curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

				$result = curl_exec($ch);
				curl_close($ch);

				return json_decode($result, true);
	}
  if(isset($_POST['register'])) {
    $ime = strip_tags(trim($_POST['fname']));
    $priimek = strip_tags(trim($_POST['lname']));
    $username = strip_tags(trim($_POST['username']));
    $email = strip_tags(trim($_POST['email']));
    $pass1 = strip_tags(trim($_POST['pass1']));
    $pass2 = strip_tags(trim($_POST['pass2']));
		$datumRegistracije = date("Y.m.d H:i:s");

		if($ime=="" || $priimek=="" || $username=="" || $email=="" || $pass1=="" || $pass2=="" || empty($_POST['spol'])) {
			echo "<strong>Niste izbrali vseh polj!</strong>";
		} else {
			if($pass1 != $pass2) {
				echo "<strong>Gesli se ne ujemata!</strong>";
			} else {
				if(strlen($pass1) < 8) {
					echo "<strong>Geslo je prekratko!</strong>";
				} else {
					$link=open_database_connection();
					$sql="SELECT username FROM uporabnik WHERE username='$username'";
					if ($result=mysqli_query($link,$sql)){
						$stVrstic=mysqli_num_rows($result);
						if($stVrstic > 0) {
							echo "<strong>Uporabniško ime že obstaja!</strong>";
						} else {
							$res = post_captcha($_POST['g-recaptcha-response']);
							if (!$res['success']) {
								echo "<strong>Potrdite da niste robot!</strong>";
							} else {
								$geslo = sha1($pass1);
								$sql="INSERT INTO uporabnik (ime, priimek, username, email, password, gender, register) VALUES ('$ime', '$priimek', '$username', '$email', '$geslo', '" . $_POST['spol'] . "', '$datumRegistracije')";
								if (!mysqli_query($link,$sql)) {
										echo("Error description: " . mysqli_error($link));
								} else {
									echo "<strong>Registracija uspešna</strong>";
								}
							}
						}
					}
					close_database_connection($link);
				}
			}
		}
  }
}

function prijava() {
	if(isset($_POST['prijava'])) {
		$username = strip_tags(trim($_POST['username']));
		$pass = strip_tags(trim($_POST['pass']));

		if($username==""||$pass==""){
			echo "<strong>Niste izpolnili vseh polj!</strong>";
		} else {
			$geslo=sha1($pass);
			$link=open_database_connection();
			//ali uporabnik obstaja
			//ali je račun zaklenjen
			//ali je geslo pravilno
			$sql="SELECT username FROM uporabnik WHERE username='$username'";
			if(!mysqli_query($link, $sql)) {
				echo "Error description: " . mysqli_error($link);
			} else {
				$result=mysqli_query($link, $sql);
				$st_vrstic=mysqli_num_rows($result);
				if($st_vrstic==0){
					echo "<strong>Uporabnik s tem uporabniškim imenom ne obstaja!</strong>";
				} else {
					$sql="SELECT username FROM uporabnik WHERE username='$username' AND nepravilnaPrijava>2";
					if(!mysqli_query($link, $sql)) {
						echo "Error description: " . mysqli_error($link);
					} else {
						$result=mysqli_query($link, $sql);
						$st_vrstic=mysqli_num_rows($result);
						if($st_vrstic!=0) {
							echo "<strong>Račun je zakljenjen!</strong>";
						} else {
							$sql="SELECT username FROM uporabnik WHERE username='$username' AND password='$geslo'";
							if(!mysqli_query($link, $sql)) {
								echo "Error description: " . mysqli_error($link);
							} else {
								$result=mysqli_query($link, $sql);
								$st_vrstic=mysqli_num_rows($result);
								if($st_vrstic==0) {
									//napacno geslo
									echo "<strong>Uporabnik s tem uporabniškim imenom in geslom ne obstaja!</strong>";
									$sql="UPDATE uporabnik SET nepravilnaPrijava=nepravilnaPrijava+1 WHERE username='$username'";
									$result=mysqli_query($link, $sql);
								} else {
									//success
									$_SESSION['upIme'] = $username;
									if(isset($_POST['ostaniPrijavljen'])) {
										setcookie("cookieUpIme", $username, time()+86400);
									}
									$sql="UPDATE uporabnik SET nepravilnaPrijava=0 WHERE username='$username' AND password='$geslo'";
									$result=mysqli_query($link, $sql);
									$cas=date("Y.m.d H:i:s");
									$sql="UPDATE uporabnik SET nazadnjePrijavljen='$cas' WHERE username='$username' AND password='$geslo'";
									$result=mysqli_query($link, $sql);
									echo "<strong>Prijava uspešna</strong>";
									header("Location: index.php");
								}
							}
						}
					}
				}
			}
			close_database_connection($link);
		}
	}
}

function odjava() {
	session_destroy();
	setcookie("cookieUpIme", $_SESSION['upIme'], time()-1);
	header("Location: index.php");
}

function samodeljnaPrijava() {
	if(isset($_COOKIE['cookieUpIme'])) {
		$_SESSION['upIme'] = $_COOKIE['cookieUpIme'];
	}
}

function kontaktiraj(){
	if(isset($_POST['posljiSporocilo'])) {
		$ime = strip_tags(trim($_POST['ime']));
		$email = strip_tags(trim($_POST['posta']));
		$text = strip_tags(trim($_POST['sporocilo']));
		$kam="denis.prelog1@gmail.com";
		if($ime==""||$email==""||$text=="") {
			echo "<p class='red'><strong>Niste izpolnili vseh podatkov!</strong></p>";
		} else {
			$sporocilo = "Sporočilo od: " . $ime . "   Email: " . $email . "   Sporočilo: " . $text;
			mail($kam, "Kontakt preko spletne strani", $sporocilo);
		}
	}
}

function pozabljenoGeslo(){
	if(isset($_POST['pozabljenoGeslo'])){
		$username=strip_tags(trim($_POST['username']));
		$email=strip_tags(trim($_POST['email']));
		if($username==""||$email==""){
			echo "Niste izpolnili vseh polj!";
		} else{
			$link=open_database_connection();
			$sql="SELECT id FROM uporabnik WHERE username='$username'";
			if(!mysqli_query($link, $sql)) {
				echo "Error description: " . mysqli_error($link);
			} else {
				$rezultat = mysqli_query($link, $sql);
				$st_vrstic = mysqli_num_rows($rezultat);
				if($st_vrstic==0) {
					echo "Uporabnik z uporabniškim imenom <strong>$username</strong> ne obstaja!";
				} else {
					$sql="SELECT id FROM uporabnik WHERE email='$email'";
					if(!mysqli_query($link, $sql)) {
						echo "Error description: " . mysqli_error($link);
					} else {
						$rezultat = mysqli_query($link, $sql);
						$st_vrstic = mysqli_num_rows($rezultat);
						if($st_vrstic==0) {
							echo "Uporabnik z tem emailom ne obstaja!";
						} else {
							$geslo = uniqid();
							$novo_geslo = sha1($geslo);
							$zadeva = "Pozabljeno geslo";
							$sporocilo = "Zahtevali ste novo geslo za strani Frizerstvo Nataša. \n \n Vaše novo geslo je " . $geslo;
							mail($email, $zadeva, $sporocilo);
							$sql="UPDATE uporabnik SET password='$novo_geslo' WHERE email='$email' AND username='$username'";
							if(!mysqli_query($link, $sql)) {
								echo "Error description: " . mysqli_error($link);
							} else {
								echo "<strong>Uspešno. </strong>Na email ste dobili sporočilo z novim geslom. Vaše geslo je: <strong>'$geslo'</strong>";
							}
						}
					}
				}
			}
			close_database_connection($link);
		}
	}
}

function dodajObjavo(){
	if(isset($_POST['objavi'])){
		/*

		$file = $_FILES['dodajsliko'];

		$fileName = $_FILES['dodajsliko']['name'];
		$fileTmpName = $_FILES['dodajsliko']['tmp_name'];
		$fileSize = $_FILES['dodajsliko']['size'];
		$fileError = $_FILES['dodajsliko']['error'];
		$fileType = $_FILES['dodajsliko']['type'];

		$fileExt = explode('.', $fileName);
		$fileActualExt = strtolower(end($fileExt));

		$allowed = array('jpg', 'jpeg', 'png');

		if(in_array($fileActualExt, $allowed)) {
			if($fileError === 0) {
				if($fileSize < 1000000) {
					$fileNameNew = uniqid('', true) . "." . $fileActualExt;
					$fileDestination = 'template/' . $fileNameNew;
					move_uploaded_file($fileTmpName, $fileDestination);
					$link = open_database_connection();
					$sql = "INSERT INTO slike (slika, besedilo) VALUES ('$fileDestination', '$besedilo')";
					if (!mysqli_query($link,$sql)){
							echo("Error description: " . mysqli_error($link));
					} else {
						echo "Uspešno naloženo";
					}
					close_database_connection($link);
				} else {
					"Prevelika datoteka!";
				}
			} else {
				echo "Napaka pri nalaganju datoteke";
			}
		} else {
			echo "Neveljavna vrsta datoteke!";
		}

		*/
		$naslov=strip_tags(trim($_POST['naslov']));
		$vsebina=strip_tags(trim($_POST['vsebina']));
		$datum = date("Y.m.d H:i:s");
		$username=$_SESSION['upIme'];
		if($naslov==""||$vsebina==""){
			echo "Niste izpolnili vseh polj!";
		} else {
			$link=open_database_connection();
			//dobimo id uporabnika ki je dodal objavo
			$sql="SELECT id FROM uporabnik WHERE username='$username'";
			if(!mysqli_query($link, $sql)) {
				echo "Error description: " . mysqli_error($link);
			} else {
				$result = mysqli_query($link, $sql);
				$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
	      $id_uporabnika =  $row['id'];
				$sql="INSERT INTO objave(idUp, naslov, vsebina, datumNastanka) VALUES ('$id_uporabnika', '$naslov', '$vsebina', '$datum');";
				if(!mysqli_query($link, $sql)) {
					echo "Error description: " . mysqli_error($link);
				} else {
					echo "Objava uspešno dodana. ";
				}
			}

			close_database_connection($link);
		}
	}
}

function izpisObjav(){
	$link=open_database_connection();
	$sql = "SELECT id, idUp, naslov, vsebina, datumNastanka FROM objave ORDER BY datumNastanka DESC;";
	$result = mysqli_query($link, $sql);
	$resultCheck = mysqli_num_rows($result);
	if($resultCheck > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$id_uporabnika = $row["idUp"];
			$sql1="SELECT ime, priimek FROM uporabnik WHERE id='$id_uporabnika';";
			$rezultat = mysqli_query($link, $sql1);
			$resultCheck1 = mysqli_num_rows($rezultat);
			if($resultCheck1 > 0) {
				while($row1 = mysqli_fetch_assoc($rezultat)){
					$celoIme = $row1['ime'] . " " . $row1['priimek'];
				}
			}
			echo "<li><div class='one_half first'><header><address>Objavil/a <a>" . $celoIme . "</a></address>";
			echo "<time>" . $row['datumNastanka'] . "</time></div>";
			if(isset($_SESSION['upIme'])){
				if($_SESSION['upIme'] == "admin"){
					echo "<div class='one_half right'><a href='index.php?stran=urediObjavo&id=" . $row["id"] . "'><i class='fa fa-edit fa-lg green'></i></a><a href='index.php?stran=izbrisiObjavo&id=" . $row['id'] . "'><i class='fa fa-close fa-lg lspace-10 red'></i></a><br><br></div>";
				} else {
					echo "<div class='one_half'><pre></pre><br><br></div>";
				}
			} else {
				echo "<div class='one_half'><pre></pre><br><br></div>";
			}
			echo "</header><div class='comcont'><p>" . $row['vsebina'] . "</p></div></li>";
		}
	}
	close_database_connection($link);
}

function informacijeUporabnika() {
	$link=open_database_connection();
	$username = $_SESSION['upIme'];
	$sql="SELECT ime, priimek, username, email, gender FROM uporabnik WHERE username='$username';";
	$result = mysqli_query($link, $sql);
	$resultCheck = mysqli_num_rows($result);
	if($resultCheck > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$_SESSION['ime'] = $row['ime'];
			$_SESSION['priimek'] = $row['priimek'];
			$_SESSION['username'] = $row['username'];
			$_SESSION['email'] = $row['email'];
			$_SESSION['spol'] = $row['gender'];
		}
	}
	close_database_connection($link);
}

function update(){
	if(isset($_POST['submit'])){
		$fname = strip_tags(trim($_POST['fname']));
		$lname = strip_tags(trim($_POST['lname']));
		$spol = strip_tags(trim($_POST['spol']));
		$username =  strip_tags(trim($_POST['username']));
		$email = strip_tags(trim($_POST['email']));
		if($fname==""||$lname==""||$email==""||$spol==""||$username==""){
			echo "<p class='red'>Niste izpolnili vseh podatkov!</p>";
			if($fname=="") {
				echo "<script>document.getElementById('fname').setAttribute('style', 'border: 1px solid red;')</script>";
			}
			if($lname=="") {
				echo "<script>document.getElementById('lname').setAttribute('style', 'border: 1px solid red;')</script>";
			}
			if($spol=="") {
				echo "<script>document.getElementById('spol').setAttribute('style', 'border: 1px solid red;')</script>";
			}
			if($username=="") {
				echo "<script>document.getElementById('username').setAttribute('style', 'border: 1px solid red;')</script>";
			}
			if($email=="") {
				echo "<script>document.getElementById('email').setAttribute('style', 'border: 1px solid red;')</script>";
			}
		}else{
			if($spol != "moski" && $spol != "zenski"){
				echo "<p class='red'>Spol je lahko samo <b>moški</b> ali <b>zenski!</b><p>";
				echo "<script>document.getElementById('spol').setAttribute('style', 'border: 1px solid red;')</script>";
			}else {
				$link=open_database_connection();
				$tmpUsername = $_SESSION['upIme'];
				$sql="SELECT id FROM uporabnik WHERE username='$tmpUsername'";
				if(!mysqli_query($link, $sql)) {
					echo "Error description: " . mysqli_error($link);
				} else {
					$result=mysqli_query($link, $sql);
					$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
					$id_uporabnika = $row['id'];
					$sql="UPDATE uporabnik SET ime='$fname', priimek='$lname', gender='$spol', email='$email', username='$username' WHERE id='$id_uporabnika'";
					if(!mysqli_query($link, $sql)) {
						echo "Error description: " . mysqli_error($link);
					} else {
						$_SESSION['upIme'] = $username;
						echo "<p class='green'>Uspešno posodobljeno</p>";
						header("refresh:1;");
					}
				}
				close_database_connection($link);
			}
		}
	}
}

function aliZaprto($date){
    $date = strtotime($date);
    $date = date("l", $date);
    $date = strtolower($date);
    if($date == "sunday" || $date == "monday") {
        return true;
    } else {
        return false;
    }
}

function narociSe(){
	if(isset($_POST['submit'])){
		if(!isset($_SESSION['upIme'])){
			echo "<p class='red'>Če se želite naročiti <b><a href='index.php?stran=prijava' class='red'>se prijavite!</a></b></p>";
		} else {
			if(!isset($_GET['date'])){
				echo "<p class='red'>Na koledarju niste izbrali datuma!</p>";
				echo "<script>document.getElementById('date').setAttribute('style', 'border: 1px solid red;')</script>";
			} else {
				$username = $_SESSION['upIme'];
				$fullName = strip_tags(trim($_POST['name']));
				$date = strip_tags(trim($_GET['date']));
				$spol = strip_tags(trim($_POST['spol']));
				$email = strip_tags(trim($_POST['email']));
				if($spol != "moski" && $spol != "Moski" && $spol != "moški" && $spol != "Moški" && $spol != "zenski" && $spol != "ženski" && $spol != "Zenski" && $spol != "Ženski" && $spol != "zenska") {
					echo "<p class='red'>Neveljaven spol! Izberete lahko samo <b>moški</b> ali <b>ženski</b>!</p>";
					echo "<script>document.getElementById('spol').setAttribute('style', 'border: 1px solid red;')</script>";
				} else {

					$narocilo = $_GET['date'];
					$datum = explode("-", $narocilo);

					$leto = $datum[0];
					$mesec = $datum[1];
					$dan = $datum[2];

					$trenutnoLeto = date("Y");
					$trenutniMesec = date("m");
					$trenutniDan = date("j");

					if($leto < $trenutnoLeto) {
						echo "<p class='red'>Ne morete izbrati preteklega leta!</p>";
						echo "<script>document.getElementById('date').setAttribute('style', 'border: 1px solid red;')</script>";
					} else {
						if($mesec < $trenutniMesec) {
							echo "<p class='red'>Ne morete izbrati preteklega mesca!</p>";
							echo "<script>document.getElementById('date').setAttribute('style', 'border: 1px solid red;')</script>";
						} else {
							if($dan < $trenutniDan) {
								echo "<p class='red'>Izbrali ste stari datum!</p>";
								echo "<script>document.getElementById('date').setAttribute('style', 'border: 1px solid red;')</script>";
							} else {
								if($dan == $trenutniDan) {
									echo "<p class='red'>Prepozno za naročitev!</p>";
								} else {
									if(aliZaprto($leto . "-" . $mesec . "-"  . $dan) == true) {
										echo "<p class='red'>Ob nedeljah in ponedelkih je <b>zaprto!</b></p>";
										echo "<script>document.getElementById('date').setAttribute('style', 'border: 1px solid red;')</script>";
									} else{
										$link=open_database_connection();
										$sql="SELECT id FROM uporabnik WHERE username='$username'";
										if(!mysqli_query($link, $sql)) {
											echo "Error description: " . mysqli_error($link);
										} else {
											$result = mysqli_query($link, $sql);
											$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
								      $id_uporabnika =  $row['id'];
											$sql1="INSERT INTO narocitve (zasedenDatum, idUp, ime, spol, email) VALUES ('$narocilo', '$id_uporabnika', '$fullName', '$spol', '$email')";
											if(!mysqli_query($link, $sql1)) {
												echo "Error description: " . mysqli_error($link);
											} else {
												echo "<p class='green'>Naročili ste se $narocilo. Če želite preklicati nas <b><a href='index.php?stran=kontakt' class='green'>kontaktirajte.</a></b></p>";
											}
										}
										close_database_connection($link);
									}
								}
							}
						}
					}

				}
			}
		}
	}
}

function izpisObjaveUredi(){
	$idObjave = $_GET['id'];
	$link=open_database_connection();
	$sql="SELECT idUp, naslov, vsebina FROM objave WHERE id='$idObjave'";
	if(!mysqli_query($link, $sql)) {
		echo "Error description: " . mysqli_error($link);
	} else {
		$result = mysqli_query($link, $sql);
		$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
		$idUp =  $row['idUp'];
		$_SESSION['naslovTmpObjave'] =  $row['naslov'];
		$_SESSION['vsebinaTmpObjave'] =  $row['vsebina'];
		$sql="SELECT ime, priimek FROM uporabnik WHERE id='$idUp';";
		if(!mysqli_query($link, $sql)) {
			echo "Error description: " . mysqli_error($link);
		} else {
			$result = mysqli_query($link, $sql);
			$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
			$_SESSION['imeUpTmpObjave'] = $row['ime'] . " " . $row['priimek'];
		}
	}
	close_database_connection($link);
}

function urediObjavo(){
	if(isset($_POST['submit'])){
		$idObjave = $_GET['id'];
		$naslov = strip_tags(trim($_POST['naslov']));
		$vsebina = strip_tags(trim($_POST['vsebina']));
		if($naslov=="" || $vsebina==""){
			echo "<p class='red'>Niste izpolnili vseh podatkov!</p>";
			if($naslov=="") {
				echo "<script>document.getElementById('naslov').setAttribute('style', 'border: 1px solid red;')</script>";
			} else if($vsebina=="") {
				echo "<script>document.getElementById('vsebina').setAttribute('style', 'border: 1px solid red;')</script>";
			}
		} else {
			$link=open_database_connection();
			$sql="UPDATE objave SET naslov='$naslov', vsebina='$vsebina' WHERE id='$idObjave';";
			if(!mysqli_query($link, $sql)) {
				echo "Error description: " . mysqli_error($link);
			} else {
				echo "<p class='green'>Uspešno posodobljeno.</p>";
				header( "refresh:1;" );
			}
			close_database_connection($link);
		}
	}
}

function spremembaGesla() {
	if(isset($_POST['submit'])) {
		$trenutnoGeslo = strip_tags(trim($_POST['cpass']));
		$trenutnoKodirano = sha1($trenutnoGeslo);
		$novoGeslo = strip_tags(trim($_POST['pass']));
		$novoGeslo2 = strip_tags(trim($_POST['pass2']));
		if($trenutnoGeslo==""||$novoGeslo==""||$novoGeslo2==""){
			echo "<p class='red'>Niste izpolnili vseh podatkov!</p>";
			if($trenutnoGeslo==""){
				echo "<script>document.getElementById('cpass').setAttribute('style', 'border: 1px solid red;')</script>";
			}
			if($novoGeslo==""){
				echo "<script>document.getElementById('pass').setAttribute('style', 'border: 1px solid red;')</script>";
			}
			if($novoGeslo2==""){
				echo "<script>document.getElementById('spol').setAttribute('style', 'border: 1px solid red;')</script>";
			}
		} else {
			if($novoGeslo!=$novoGeslo2) {
				echo "<p class='red'>Gesli se ne ujemata!</p>";
				echo "<script>document.getElementById('pass').setAttribute('style', 'border: 1px solid red;')</script>";
				echo "<script>document.getElementById('pass2').setAttribute('style', 'border: 1px solid red;')</script>";
			} else {
				$link=open_database_connection();
				$username = $_SESSION['upIme'];
				$sql="SELECT password FROM uporabnik WHERE username='$username';";
				if(!mysqli_query($link, $sql)) {
					echo "Error description: " . mysqli_error($link);
				} else {
					$result=mysqli_query($link,$sql);
					$stVrstic=mysqli_num_rows($result);
					if($stVrstic == 0) {
						echo "<p class='red'>Vpisali ste napačno geslo!</p>";
						echo "<script>document.getElementById('cpass').setAttribute('style', 'border: 1px solid red;')</script>";
					} else if($stVrstic > 0) {
						$sql="SELECT password FROM uporabnik WHERE username='$username' AND password='$trenutnoKodirano';";
						$result = mysqli_query($link, $sql);
						$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
						if($trenutnoKodirano != $row['password']) {
							echo "<p class='red'>Vpisali ste napačno geslo!</p>";
							echo "<script>document.getElementById('cpass').setAttribute('style', 'border: 1px solid red;')</script>";
						} else {
							if(strlen($novoGeslo) < 8) {
								echo "<p class='red'>Prekratko geslo! Geslo mora biti vsaj 8 znakov. </p>";
								echo "<script>document.getElementById('pass').setAttribute('style', 'border: 1px solid red;')</script>";
								echo "<script>document.getElementById('pass2').setAttribute('style', 'border: 1px solid red;')</script>";
							} else {
								if($trenutnoGeslo == $novoGeslo) {
									echo "<p class='red'>Novo geslo ne more biti enako staremu!</p>";
									echo "<script>document.getElementById('pass').setAttribute('style', 'border: 1px solid red;')</script>";
									echo "<script>document.getElementById('pass2').setAttribute('style', 'border: 1px solid red;')</script>";
								} else {
									$kodiranoGeslo = sha1($novoGeslo);
								 $sql="UPDATE uporabnik SET password='$kodiranoGeslo' WHERE username='$username' AND password='$trenutnoKodirano';";
								 if(!mysqli_query($link, $sql)) {
				 						echo "Error description: " . mysqli_error($link);
				 					} else {
										echo "<p class='green'>Geslo uspešno spremenjeno. </p>";
									}
								}
							}
						}
					} else {
						echo "<p class='red'>Napaka</p>";
					}
				}
				close_database_connection($link);
			}
		}
	}
}

function izbrisStarihNarocitev() {
	$link=open_database_connection();
	date_default_timezone_set('Europe/Ljubljana');
	$today = date('Y-m-j', time());
	$sql="DELETE FROM narocitve WHERE zasedenDatum<='$today';";
	if(!mysqli_query($link, $sql)) {
		echo "Error description: " . mysqli_error($link);
	} else {
		mysqli_query($link, $sql);
	}
	close_database_connection($link);
}
 ?>
