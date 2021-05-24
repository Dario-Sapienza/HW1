<?php    

include 'sessione.php';
    if (controlloAccesso()) 
    {

$utente=$_SESSION["fit_advisor_utente"];

$conn = mysqli_connect('localhost','root','','palestre') or die(mysqli_error($conn));
$query = "SELECT utente, codice_palestra ,nome_palestra ,immagine, descrizione FROM preferiti where utente='$utente'" ;
$res = mysqli_query($conn, $query) or die(mysqli_error($conn));

if (mysqli_num_rows($res) > 0) {
    while($entry = mysqli_fetch_assoc($res)) {
        $preferiti[] = array("utente" => $entry["utente"], 
                             "codice_palestra" => $entry["codice_palestra"], 
                             "nome_palestra" => $entry["nome_palestra"], 
                            "immagine" => $entry["immagine"],
                            "descrizione" => $entry["descrizione"]);
    }
}
    mysqli_close($conn);
    if(mysqli_num_rows($res) > 0)
    {
    echo json_encode($preferiti);
    exit;
    }
}
    echo json_encode(1);
    

?>