<?php
    
    if (!isset($_GET["q"])) {
        echo "ERRORE!!!";
        exit;
    }

    header('Content-Type: application/json');
    
    $conn = mysqli_connect('localhost', 'root', '', 'palestre') or die(mysqli_error($conn));

    $mail = mysqli_real_escape_string($conn, $_GET["q"]);

    $query = "SELECT mail FROM utente WHERE mail = '$mail'";

    
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

    // Torna un JSON con chiave exists e valore boolean
    echo json_encode(array('exists' => mysqli_num_rows($res) > 0 ? true : false));

    mysqli_close($conn);
?>