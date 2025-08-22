<?php

include 'db.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST['name'];
    $email = $_POST['email'];

    $sql = "UPDATE times SET name ='$nome',cidade ='$cidade' WHERE id=$id";

    if ($conn->query($sql) === true) {
        echo "Registro atualizado com sucesso.
        <a href='read.times.php'>Ver registros.</a>
        ";
    } else {
        echo "Erro " . $sql . '<br>' . $conn->error;
    }
    $conn->close();
    exit(); 
}

$sql = "SELECT * FROM times WHERE id=$id";
$result = $conn -> query($sql);
$row = $result -> fetch_assoc();


?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update</title>
</head>

<body>

    <form method="POST" action="update.times.php?id=<?php echo $row['id'];?>">

        <label for="name">Nome do Time:</label>
        <input type="text" name="name" value="<?php echo $row['nome'];?>" required>

        <label for="name">Cidade do time:</label>
        <input type="name" name="name" value="<?php echo $row['cidade'];?>" required>

        <input type="submit" value="Atualizar">

    </form>

    <a href="read.times.php">Ver registros.</a>

</body>

</html>