<?php
include_once 'db.times.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
   
    $sql_check = "SELECT COUNT(*) as total FROM jogadores WHERE time_id = $id";
    $result_check = mysqli_query($conn, $sql_check);
    $row = mysqli_fetch_assoc($result_check);
    
    if ($row['total'] > 0) {
        header("Location: read.times.php?erro=Este time possui jogadores associados e não pode ser deletado.");
        exit();
    }

    $sql_check_partidas = "SELECT COUNT(*) as total FROM partidas WHERE time_casa_id = $id OR time_fora_id = $id";
    $result_check_partidas = mysqli_query($conn, $sql_check_partidas);
    $row_partidas = mysqli_fetch_assoc($result_check_partidas);
    
    if ($row_partidas['total'] > 0) {
        header("Location: read.times.php?erro=Este time está envolvido em partidas e não pode ser deletado.");
        exit();
    }
    
    $sql = "DELETE FROM times WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: read.times.php?sucesso=Time deletado com sucesso!");
        exit();
    } else {
        header("Location: read.times.php?erro=Erro ao deletar time: " . urlencode(mysqli_error($conn)));
        exit();
    }
} else {
    header("Location: read.times.php");
    exit();
}
?>
