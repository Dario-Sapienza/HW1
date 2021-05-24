<?php

include 'sessione.php';
    if (controlloAccesso()) {
        header('Location: mhw1.php');
        exit;
    }

if (!empty($_POST["username"]) && !empty($_POST["password"]) )
{
  
    $conn = mysqli_connect('localhost', 'root', '', 'palestre') or die(mysqli_error($conn));
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $searchField = filter_var($username, FILTER_VALIDATE_EMAIL) ? "email" : "username";
    $query = "SELECT username, password, cognome FROM utente WHERE $searchField = '$username'";
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));;
    if (mysqli_num_rows($res) > 0) {
        $entry = mysqli_fetch_assoc($res);
        if (password_verify($_POST['password'], $entry['password'])) 
        {
            $_SESSION["fit_advisor_utente"] = $entry['username'];
            $_SESSION["fit_advisor_cognome"] = $entry["cognome"];
            header("Location: mhw1.php");
            mysqli_free_result($res);
            mysqli_close($conn);
            exit;
        }
    }
    $error = "Username e/o password errati.";
}
else if (isset($_POST["username"]) || isset($_POST["password"])) {
    $error = "Inserisci username e password.";
}

?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel='stylesheet' href='accesso.css'>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300&display=swap" rel="stylesheet">
        
        
        <title>Fit-Advisor - Accedi</title>
    </head>
    <body>
        <section class="accesso">
            <h1>Fit-Advisor</h1>
            <?php
                if (isset($error)) {
                    echo "<span class='error'>$error</span>";
                }
                
            ?>
            <form name='login' method='post'>
                <div class="username">
                    <input type='text' name='username' placeholder="username o e-mail" <?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?>>
                </div>
                <div class="password">
                    <input type='password' name='password' placeholder="password"<?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>>
                </div>
                <div>
                    <input type='submit' value="Accedi">
                </div>
            </form>
            <div class="account">Non hai un account? <a class="iscrizione" href="iscrizione.php">Iscriviti</a></div>
            <div> <a class='home_page' href="mhw1.php">Home page</a></div>
        </section>
    </body>
</html>