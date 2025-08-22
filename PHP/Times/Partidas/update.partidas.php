<?php
include_once 'db.partidas.php';

$id = $_GET['id'];
$sql = "SELECT * FROM partidas WHERE id = $id";
$resultado = mysqli_query($conn, $sql);
$partida = mysqli_fetch_assoc($resultado);

if (!$partida) {
    die("Partida não encontrada.");
}

$sql_times = "SELECT * FROM times ORDER BY nome";
$resultado_times = mysqli_query($conn, $sql_times);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $time_casa_id = mysqli_real_escape_string($conn, $_POST['time_casa_id']);
    $time_fora_id = mysqli_real_escape_string($conn, $_POST['time_fora_id']);
    $data_jogo = mysqli_real_escape_string($conn, $_POST['data_jogo']);
    $gols_casa = mysqli_real_escape_string($conn, $_POST['gols_casa']);
    $gols_fora = mysqli_real_escape_string($conn, $_POST['gols_fora']);
    
    if ($time_casa_id == $time_fora_id) {
        $erro = "Os times não podem ser iguais!";
    } else {
        $sql = "UPDATE partidas SET time_casa_id = '$time_casa_id', time_fora_id = '$time_fora_id', 
                data_jogo = '$data_jogo', gols_casa = '$gols_casa', gols_fora = '$gols_fora' 
                WHERE id = $id";
        
        if (mysqli_query($conn, $sql)) {
            header("Location: read.partidas.php");
            exit();
        } else {
            $erro = "Erro ao atualizar partida: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Partida</title>
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
        input[type="date"], input[type="number"], select {
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
        .placar {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .placar input {
            width: 60px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>✏️ Editar Partida</h1>
        
        <?php if (isset($erro)): ?>
            <div class="error"><?php echo $erro; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="time_casa_id">Time da Casa:</label>
                <select id="time_casa_id" name="time_casa_id" required>
                    <option value="">Selecione o time da casa</option>
                    <?php 
                    mysqli_data_seek($resultado_times, 0);
                    while($time = mysqli_fetch_assoc($resultado_times)): ?>
                        <option value="<?php echo $time['id']; ?>" <?php echo $partida['time_casa_id'] == $time['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($time['nome']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="time_fora_id">Time Visitante:</label>
                <select id="time_fora_id" name="time_fora_id" required>
                    <option value="">Selecione o time visitante</option>
                    <?php 
                    mysqli_data_seek($resultado_times, 0);
                    while($time = mysqli_fetch_assoc($resultado_times)): ?>
                        <option value="<?php echo $time['id']; ?>" <?php echo $partida['time_fora_id'] == $time['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($time['nome']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="data_jogo">Data do Jogo:</label>
                <input type="date" id="data_jogo" name="data_jogo" value="<?php echo $partida['data_jogo']; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Placar:</label>
                <div class="placar">
                    <input type="number" name="gols_casa" value="<?php echo $partida['gols_casa']; ?>" required min="0" max="20">
                    <span>X</span>
                    <input type="number" name="gols_fora" value="<?php echo $partida['gols_fora']; ?>" required min="0" max="20">
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn">💾 Atualizar Partida</button>
                <a href="read.partidas.php" class="btn btn-secondary">❌ Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
