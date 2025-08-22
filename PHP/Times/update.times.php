<?php
include_once 'db.times.php';

$id = $_GET['id'];
$sql = "SELECT * FROM times WHERE id = $id";
$resultado = mysqli_query($conn, $sql);
$time = mysqli_fetch_assoc($resultado);

if (!$time) {
    die("Time não encontrado.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $cidade = mysqli_real_escape_string($conn, $_POST['cidade']);
    
    $sql = "UPDATE times SET nome = '$nome', cidade = '$cidade' WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: read.times.php");
        exit();
    } else {
        $erro = "Erro ao atualizar time: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Time</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background: #0056b3;
        }
        .btn-secondary {
            background: #6c757d;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
        .error {
            color: #dc3545;
            background: #f8d7da;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>✏️ Editar Time</h1>
        
        <?php if (isset($erro)): ?>
            <div class="error"><?php echo $erro; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="nome">Nome do Time:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($time['nome']); ?>" required maxlength="100">
            </div>
            
            <div class="form-group">
                <label for="cidade">Cidade:</label>
                <input type="text" id="cidade" name="cidade" value="<?php echo htmlspecialchars($time['cidade']); ?>" required maxlength="100">
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn">💾 Atualizar Time</button>
                <a href="read.times.php" class="btn btn-secondary">❌ Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
