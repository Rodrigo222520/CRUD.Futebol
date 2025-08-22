<?php
include_once 'db.partidas.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "DELETE FROM partidas WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: read.partidas.php?sucesso=Partida deletada com sucesso!");
        exit();
    } else {
        header("Location: read.partidas.php?erro=Erro ao deletar partida: " . urlencode(mysqli_error($conn)));
        exit();
    }
} else {
    header("Location: read.partidas.php");
    exit();
}
?>
