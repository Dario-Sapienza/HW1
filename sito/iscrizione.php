<?php
    require_once 'sessione.php';

    if (controlloAccesso()) {
        header("Location: mhw1.php");
        exit;
    }   

    if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["mail"]) && !empty($_POST["nome"]) && 
        !empty($_POST["cognome"]) && !empty($_POST["conferma_password"]) && !empty($_POST["eta"]))
    {
        $error = array();
        $conn = mysqli_connect('localhost', 'root', '', 'palestre') or die(mysqli_error($conn));

        
        # USERNAME
        if(!preg_match('/^[a-zA-Z0-9_]{1,15}$/', $_POST['username'])) {
            $error[] = "Username non valido";
        } else {
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $query = "SELECT username FROM utente WHERE username = '$username'";
            $res = mysqli_query($conn, $query);
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Username già utilizzato";
            }
        }
        # PASSWORD
        if (strlen($_POST["password"]) < 8) {
            $error[] = "Caratteri password insufficienti";
        } 
        # CONFERMA PASSWORD
        if (strcmp($_POST["password"], $_POST["conferma_password"]) != 0) {
            $error[] = "Le password non coincidono";
        }
        # EMAIL
        if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
            $error[] = "Email non valida";
        } else {
            $mail = mysqli_real_escape_string($conn, strtolower($_POST['mail']));
            $res = mysqli_query($conn, "SELECT mail FROM utente WHERE mail = '$mail'");
            if (mysqli_num_rows($res) > 0) {
                $error[] = "E-mail già utilizzata";
            }
        }

        
        # REGISTRAZIONE NEL DATABASE
        if (count($error) == 0) {
            $nome = mysqli_real_escape_string($conn, $_POST['nome']);
            $cognome = mysqli_real_escape_string($conn, $_POST['cognome']);
            $eta = $_POST['eta'];

            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $password = password_hash($password, PASSWORD_BCRYPT);

            $query = "INSERT INTO utente(username, password, nome, cognome, mail, eta) VALUES('$username', '$password', '$nome', '$cognome', '$mail', '$eta')";
            
            if (mysqli_query($conn, $query)) {
                $_SESSION["fit_advisor_utente"] = $_POST["username"];
                $_SESSION["fit_advisor_cognome"] = $_POST["cognome"];

                mysqli_close($conn);
                header("Location: mhw1.php");
                exit;
            } else {
                $error[] = "Errore di connessione al Database";
            }
        }

        mysqli_close($conn);
    }
    else if (isset($_POST["username"])) {
        $error = array("Riempi tutti i campi");
    }

?>


<html>
    <head>
        <link rel='stylesheet' href='iscrizione.css'>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300&display=swap" rel="stylesheet">
        <script src='iscrizione.js' defer></script>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">

        <title>Fit Advisor - Iscriviti</title>
    </head>
    <body>
         <section class = "iscrizione">  
         <h1>Fit-Advisor</h1>   
         <?php
                if (isset($error)) {
                    echo "<span class='error'>RIEMPI TUTTI I CAMPI</span>";
                }
                
            ?>            <form name='iscrizione' method='post' enctype="multipart/form-data" autocomplete="off">
                    <div class="nome">
                        <input type='text' name='nome' placeholder="nome" <?php if(isset($_POST["nome"])){echo "value=".$_POST["nome"];} ?> >
                        <span></span>
                    </div>
                    <div class="cognome">
                        <input type='text' name='cognome' placeholder="cognome" <?php if(isset($_POST["cognome"])){echo "value=".$_POST["cognome"];} ?> >
                        <span></span>
                    </div>
                <div class="username">
                    <input type='text' name='username' placeholder="username"<?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?>>
                   <span></span>
                </div>
                <div class="mail">
                    <input type='text' name='mail' placeholder="e-mail"<?php if(isset($_POST["mail"])){echo "value=".$_POST["mail"];} ?>>
                    <span></span>
                </div>
                <div class="password">
                    <input type='password' name='password' placeholder="password" <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>>
                    <span></span>
                </div>
                <div class="conferma_password">
                    <input type='password' name='conferma_password' placeholder="conferma password"<?php if(isset($_POST["conferma_password"])){echo "value=".$_POST["conferma_password"];} ?>>
                    <span></span>
                </div>
                <div class="eta">
                    <input type='number' name='eta' min = '1' placeholder="eta'"<?php if(isset($_POST["eta"])){echo "value=".$_POST["eta"];} ?>>
                </div>
               
                <div class="submit">
                    <input type='submit' value="Registrati" id="submit">
                </div>
            </form>
            <div class="account">Hai gia' un account? </br><a class='accesso' href="accesso.php">Accedi</a></div>
            <div> <a class='home_page' href="mhw1.php">Home page</a></div>
            </section>

    </body>
</html>