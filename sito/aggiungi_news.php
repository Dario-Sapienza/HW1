<?php

include 'sessione.php';
    if (controlloAccesso()) {
        

  $utente=$_SESSION["fit_advisor_utente"];
  $link = $_GET["q"];
  $titolo = $_GET["t"];


  $conn = mysqli_connect('localhost','root','','palestre') or die(mysqli_error($conn));
  $query= "INSERT INTO azioni_news values('$utente','$titolo','$link')";

  $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

        }
?>