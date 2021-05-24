<?php

include 'sessione.php';

?>

<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Galleria palestre</title>
    <link rel="stylesheet" href="nuove_aperture.css">
    <script src="mhw3.js" defer = "true"></script>
    <script src="menu_mobile.js" defer = "true"></script>
    <link rel = "preconnect" href = "https://fonts.gstatic.com">
    <link href ="https://fonts.googleapis.com/css2?family=PT+Sans+Caption&display=swap" rel = "stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Russo+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Train+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&display=swap" rel="stylesheet">
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
        <?php
         if(controlloAccesso())
           echo   "<a href = uscita.php class = button>Esci</a>";
         
         else
           echo "  <a href = accesso.php class = button>Accedi</a>";
        ?>        <div id="menu">
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
     </header>
    <article>  
    <h1>
      <strong>NUOVE AFFILIAZIONI</strong></br>
    </h1>
    <p id = "a" >Visita le nostre prossime collaborazioni</p>
    <section id='nuove_affiliazioni'></section>
    <section id="zoom" class="hidden"> 
		
		</section>
    </article>

    <footer>
      <address>Fit Advisor - Catania</address>
      <img src="Logo.png"/>
      <p>Dario Sapienza O46001787</p>
    </footer>
  </body>
</html>