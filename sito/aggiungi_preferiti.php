
<?php

include 'sessione.php';
    if (controlloAccesso()) {
        

  $utente=$_SESSION["fit_advisor_utente"];
  $palestra = $_GET["q"];

  $conn = mysqli_connect('localhost','root','','palestre') or die(mysqli_error($conn));
  $query = "SELECT nome, immagine, descrizione FROM palestra where codice ='$palestra'" ;

  $res1 = mysqli_query($conn, $query) or die(mysqli_error($conn));

  $query = "SELECT  count(*) from preferiti where utente ='$utente' and codice_palestra='$palestra'";
  $res2 = mysqli_query($conn, $query) or die(mysqli_error($conn));
  $entry2 = mysqli_fetch_assoc($res2);
  if (mysqli_num_rows($res1) > 0 && $entry2["count(*)"] == 0) {
     $entry1 = mysqli_fetch_assoc($res1);
     $nome_palestra = $entry1["nome"];
     $immagine = $entry1["immagine"];
     $descrizione = $entry1["descrizione"];
     $query= "INSERT INTO preferiti values('$utente','$palestra','$nome_palestra',' $immagine','$descrizione')";
     $res3 = mysqli_query($conn, $query) or die(mysqli_error($conn));
     mysqli_close($conn);
    
     exit;
    }
  else{
    mysqli_close($conn);
    # echo ('1');
    exit;
          }

        }
?>