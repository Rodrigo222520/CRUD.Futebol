<?php
include_once 'db.jogadores.php';

// Processar exclusão do jogador
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "DELETE FROM jogadores WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: read.jogadores.php?sucesso=Jogador deletado com sucesso!");
        exit();
    } else {
        header("Location: read.jogadores.php?erro=Erro ao deletar jogador: " . urlencode(mysqli_error($conn)));
        exit();
    }
} else {
    header("Location: read.jogadores.php");
    exit();
}
?>
