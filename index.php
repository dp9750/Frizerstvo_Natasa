<?php
session_start();
include "model.php";
include "funkcije.php";
samodeljnaPrijava();
izbrisStarihNarocitev();

if(isset($_GET['stran'])) {
  if($_GET['stran'] == "narociSe") {
    include "template/narociSe.html.php";
  } else if($_GET['stran'] == "registracija" && (!isset($_SESSION['upIme']))) {
    include "template/registracija.html.php";
  } else if($_GET['stran'] == "prijava" && (!isset($_SESSION['upIme']))) {
    include "template/prijava.html.php";
  } else if($_GET['stran'] == "kontakt") {
    include "template/kontakt.html.php";
  } else if($_GET['stran'] == "spremembaGesla" && isset($_SESSION['upIme'])) {
    include "template/spremembaGesla.html.php";
  } else if($_GET['stran'] == "profil") {
    if(isset($_SESSION['upIme'])) {
      include "template/profil.html.php";
    } else if(!isset($_SESSION['upIme'])){
      include "template/prijaviSe.html.php";
    } else {
      include "template/error.html.php";
    }
  } else if($_GET['stran'] == "objave") {
    include "template/objave.html.php";
  } else if($_GET['stran'] == "dodajObjavo"){
    if(isset($_SESSION['upIme'])){
      include "template/dodajObjavo.html.php";
    } else if(!isset($_SESSION['upIme'])) {
      include "template/prijaviSe.html.php";
    } else {
      include "template/error.html.php";
    }
  } else if($_GET['stran'] == "odjava" && isset($_SESSION['upIme'])) {
    odjava();
    header("Location: index.php");
  } else if($_GET['stran'] == "pozabljenoGeslo" && (!isset($_SESSION['upIme']))) {
    include "template/pozabljenoGeslo.html.php";
  } else if($_GET['stran'] == 'urediObjavo') {
    if(isset($_SESSION['upIme'])) {
      if($_SESSION['upIme'] == "admin") {
        include "template/urediObjavo.html.php";
      } else {
        include "template/error.html.php";
      }
    } else {
      include "template/error.html.php";
    }
  } else if($_GET['stran'] == "izbrisiObjavo"){
    if(isset($_SESSION['upIme'])) {
      if($_SESSION['upIme'] == "admin") {
        include "template/izbrisiObjavo.html.php";
      } else {
        include "template/error.html.php";
      }
    } else {
      include "template/error.html.php";
    }
  } else {
    include "template/error.html.php";
  }
} else {
  include "template/index.html.php";
}
 ?>
