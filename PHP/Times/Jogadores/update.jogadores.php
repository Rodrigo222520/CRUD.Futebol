<?php
include_once 'db.jogadores.php';

$id = $_GET['id'];
$sql = "SELECT * FROM jogadores WHERE id = $id";
$resultado = mysqli_query($conn, $sql);
$jogador = mysqli_fetch_assoc($resultado);

if (!$jogador) {
    die("Jogador não encontrado.");
}

$sql_times = "SELECT * FROM times ORDER BY nome";
$resultado_times = mysqli_query($conn, $sql_times);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $posicao = mysqli_real_escape_string($conn, $_POST['posicao']);
    $numero_camisa = mysqli_real_escape_string($conn, $_POST['numero_camisa']);
    $time_id = mysqli_real_escape_string($conn, $_POST['time_id']);
    
    $sql = "UPDATE jogadores SET nome = '$nome', posicao = '$posicao', 
            numero_camisa = '$numero_camisa', time_id = " . ($time_id ? "'$time_id'" : "NULL") . " 
            WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: read.jogadores.php");
        exit();
    } else {
        $erro = "Erro ao atualizar jogador: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Jogador</title>
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
        input[type="text"], input[type="number"], select {
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
        <h1>✏️ Editar Jogador</h1>
        
        <?php if (isset($erro)): ?>
            <div class="error"><?php echo $erro; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="nome">Nome do Jogador:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($jogador['nome']); ?>" required maxlength="100">
            </div>
            
            <div class="form-group">
                <label for="posicao">Posição:</label>
                <select id="posicao" name="posicao" required>
                    <option value="">Selecione a posição</option>
                    <option value="GOL" <?php echo $jogador['posicao'] == 'GOL' ? 'selected' : ''; ?>>Goleiro (GOL)</option>
                    <option value="ZAG" <?php echo $jogador['posicao'] == 'ZAG' ? 'selected' : ''; ?>>Zagueiro (ZAG)</option>
                    <option value="LAT" <?php echo $jogador['posicao'] == 'LAT' ? 'selected' : ''; ?>>Lateral (LAT)</option>
                    <option value="VOL" <?php echo $jogador['posicao'] == 'VOL' ? 'selected' : ''; ?>>Volante (VOL)</option>
                    <option value="MEI" <?php echo $jogador['posicao'] == 'MEI' ? 'selected' : ''; ?>>Meio-campista (MEI)</option>
                    <option value="ATA" <?php echo $jogador['posicao'] == 'ATA' ? 'selected' : ''; ?>>Atacante (ATA)</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="numero_camisa">Número da Camisa:</label>
                <input type="number" id="numero_camisa" name="numero_camisa" value="<?php echo $jogador['numero_camisa']; ?>" required min="1" max="99">
            </div>
            
            <div class="form-group">
                <label for="time_id">Time:</label>
                <select id="time_id" name="time_id">
                    <option value="">Selecione o time (opcional)</option>
                    <?php 

                    mysqli_data_seek($resultado_times, 0);
                    while($time = mysqli_fetch_assoc($resultado_times)): ?>
                        <option value="<?php echo $time['id']; ?>" <?php echo $jogador['time_id'] == $time['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($time['nome']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn">💾 Atualizar Jogador</button>
                <a href="read.jogadores.php" class="btn btn-secondary">❌ Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
