<?php   



$conn = mysqli_connect('localhost','root','','palestre') or die(mysqli_error($conn));


$query = "SELECT codice, nome, immagine, descrizione FROM palestra" ;

$res = mysqli_query($conn, $query) or die(mysqli_error($conn));
if (mysqli_num_rows($res) > 0) {
    while($entry = mysqli_fetch_assoc($res)) {
        $palestre[] = array( "id_palestra" => $entry["codice"],
                            "nome_palestra" => $entry["nome"], 
                            "immagine" => $entry["immagine"], 
                            "descrizione" => $entry["descrizione"]);
    }

mysqli_close($conn);
echo json_encode($palestre);
exit;

}
?>

