<?php

include 'sessione.php';

?>

<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fit Advisor</title>
    <link rel="stylesheet" href="mhw1.css">
    <script src="menu_mobile.js" defer = "true"></script>
    <link rel = "preconnect" href = "https://fonts.gstatic.com">
    <link href = "https://fonts.googleapis.com/css2?family=PT+Sans+Caption&display=swap" rel = "stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Russo+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rokkitt:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Train+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nova+Flat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bungee+Shade&family=Rubik+Mono+One&display=swap" rel="stylesheet">
  </head>
  <body>
     <header>
      <nav>
       <div id="logo">
        <img id = "FitAd-logo" src = "Logo.png" /> 
       </div>
      <div class="links">
        <a href = "mhw1.php">Home</a>
        <a href = "mhw2.php">Palestre</a>
        <a target = "blank" href = "https://www.google.it/maps/@37.5378544,15.0477241,11.92z/data=!4m3!11m2!2sfncJ2psGmTCFdvktjOwFTSGXr2p66A!3e3">Mappa</a>
        <?php
        if(controlloAccesso()){
           echo   "<a href = area_personale.php>Area Personale</a>";
           }
         else
           echo "  <a href = reindirizzamento3.html>Area Personale</a>";
           ?>
        </div>
        <div>
        <?php
         if(controlloAccesso()){
          echo $_SESSION['fit_advisor_utente'];
           echo   "<a href = uscita.php class = button>Esci</a>";
           }
         else
           echo "  <a href = accesso.php class = button>Accedi</a>";
        ?>
        </div>
       <div id="menu">
        <div></div>
        <div></div>
        <div></div>
      </div>
      </nav>
      <div id="links_menu" class="hidden">  
      <a href = "mhw1.php">Home</a>
        <a href = "mhw2.php">Palestre</a>
        <a target = "blank" href = "https://www.google.it/maps/@37.5378544,15.0477241,11.92z/data=!4m3!11m2!2sfncJ2psGmTCFdvktjOwFTSGXr2p66A!3e3">Mappa</a>
       
        <?php
        if(controlloAccesso()){
           echo   "<a href = area_personale.php>Area Personale</a>";
           }
         else
           echo "  <a href = reindirizzamento3.html>Area Personale</a>";
           ?>


        <?php
         if(controlloAccesso()){
           echo   "<a href = uscita.php class = button1>Esci</a>";
           }
         else
           echo "  <a href = accesso.php class = button1>Accedi</a>";
        ?>
    </div>
      <h1>
        <strong>FREQUENTA LE MIGLIORI PALESTRE DI CATANIA</strong></br>
        <a href = "piu_info.php" id = "info-button">Più info</a>  
      </h1>
     </header>
    <section>
      <div class = "mini-sezione1" >
        
      <?php
         if(controlloAccesso()){
           echo   "<a href= prenotazione_corso.php> CERCA IL CORSO CHE FA PIU' AL CASO TUO E PRENOTATI SUBITO</a>";
           }
         else
           echo " <a href = reindirizzamento.html> CERCA IL CORSO CHE FA PIU' AL CASO TUO E PRENOTATI SUBITO</a> ";
        ?>
        <img class = "immagine" src= "img-corsi.jfif"/>
      </div>
      <div class = "mini-sezione2" >
        <img class = "immagine" src= "img-affiliazioni.jfif"/>
        <img class = "immagine" src= "palestra.jpg"/>
        <a href= "nuove_aperture.php">TANTE NUOVE AFFILIAZIONI PRESTO DISPONIBILI</a>
      </div>
      <div class = "mini-sezione3" >
        <a href= "mhw3.php">CONOSCI I NOSTRI ATLETI E RIMANI AGGIORNATO SULLE NEWS</a>
        <img class = "immagine" src= "avvisi.jfif"/>
      </div>
    </section>
    <footer>
      <address>Fit Advisor - Catania</address>
      <img src="Logo.png"/>
      <p>Dario Sapienza O46001787</p>
    </footer>
  </body>
</html>