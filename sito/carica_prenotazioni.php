<?php    

include 'sessione.php';
    if (controlloAccesso()) 
    {

    $utente = $_SESSION["fit_advisor_utente"];

$conn = mysqli_connect('localhost','root','','palestre') or die(mysqli_error($conn));
$query = "SELECT p.nome, pc.corso 
           FROM palestra p JOIN prenotazione_corso pc on p.codice = pc.palestra 
           WHERE pc.username = '$utente'" ;
$res = mysqli_query($conn, $query) or die(mysqli_error($conn));

if (mysqli_num_rows($res) > 0) {
    while($entry = mysqli_fetch_assoc($res)) {
        $prenotazioni[] = array( "nome_palestra" => $entry["nome"],
                                 "nome_corso" => $entry["corso"]);
    }
    mysqli_close($conn);
    
    echo json_encode($prenotazioni);
    exit;
    }
}
    echo json_encode(1);
    

?>