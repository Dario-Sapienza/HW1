<?php   

$conn = mysqli_connect('localhost','root','','palestre') or die(mysqli_error($conn));


$query = "SELECT indirizzo, nome FROM nuove_affiliazioni" ;

$res = mysqli_query($conn, $query) or die(mysqli_error($conn));
if (mysqli_num_rows($res) > 0) {

    while($entry = mysqli_fetch_assoc($res)) {
        $nuove_affiliazioni[] = array( "indirizzo" => $entry["indirizzo"],
                                       "nome" => $entry["nome"]);
    }

mysqli_close($conn);
echo json_encode($nuove_affiliazioni);
exit;

}
?>

