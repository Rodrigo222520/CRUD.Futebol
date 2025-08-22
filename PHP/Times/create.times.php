<?php

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = $_POST['nome'];
    $cidade = $_POST['cidade'];

    $sql = " INSERT INTO times (nome,cidade) VALUE ('$nome','$cidade')";

    if ($conn->query($sql) === true) {
        echo "Novo registro criado com sucesso.";
    } else {
        echo "Erro " . $sql . '<br>' . $conn->error;
    }
    $conn->close();
}

?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create</title>
</head>

<body>

    <form method="POST" action="create.php">

        <label for="name">Nome do Time:</label>
        <input type="text" name="name" required>

        <label for="name">Cidade do Time:</label>
        <input type="name" name="name" required>

        <input type="submit" value="Adicionar">

    </form>

    <a href="read.php">Ver registros.</a>

</body>

</html>