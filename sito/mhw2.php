<?php

include 'sessione.php';

?>

<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Galleria palestre</title>
    <link rel="stylesheet" href="mhw2.css">
    <script src="contents.js" defer = "true"></script>
    <script src="script.js" defer = "true"></script>
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
    <link href="https://fonts.googleapis.com/css2?family=Audiowide&family=Staatliches&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nova+Square&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bungee+Inline&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Saira+Stencil+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arbutus&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
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
        ?>
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
        <strong>PALESTRE</strong></br>
      </h1>
     </header>

    <article>  

      <h1 id = "pre" class = "hidden">- PREFERITI -</h1>
      <section id = "preferiti" class = "hidden contenuto">
      </section>

<section id="ricerca">
  <input type="text" placeholder = "Cerca">
</section>
<section id="contenuti" class ="contenuto"> </section>

    </article>

    <footer>
      <address>Fit Advisor - Catania</address>
      <img src="Logo.png"/>
      <p>Dario Sapienza O46001787</p>
    </footer>
  </body>
</html>

