<?php
include_once 'db.partidas.php';

$busca = '';
$where = '';
if (isset($_GET['busca']) && !empty($_GET['busca'])) {
    $busca = mysqli_real_escape_string($conn, $_GET['busca']);
    $where = "WHERE tc.nome LIKE '%$busca%' OR tf.nome LIKE '%$busca%' OR p.data_jogo LIKE '%$busca%'";
}

$sql = "SELECT p.*, 
               tc.nome as time_casa_nome, 
               tf.nome as time_fora_nome 
        FROM partidas p 
        LEFT JOIN times tc ON p.time_casa_id = tc.id
        LEFT JOIN times tf ON p.time_fora_id = tf.id 
        $where
        ORDER BY p.data_jogo DESC";
$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Partidas</title>
    <link rel="stylesheet" href="../../../style.css">
</head>
<body>
    <div class="container container-list">
        <h1>⚽ Lista de Partidas</h1>
        
        <?php if (isset($_GET['sucesso'])): ?>
            <div class="success-message">
                ✅ <?php echo htmlspecialchars($_GET['sucesso']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['erro'])): ?>
            <div class="error-message">
                ❌ <?php echo htmlspecialchars($_GET['erro']); ?>
            </div>
        <?php endif; ?>
        
        <div class="flex gap-10 align-center mb-20">
            <a href="create.partidas.php" class="btn">➕ Adicionar Partida</a>
            <a href="../../../index.php" class="back-btn">⬅️ Voltar ao Menu</a>
        </div>

        <div class="filter-buttons">
            <button type="button" class="btn btn-secondary" onclick="filterByResult('Vitória')">🏆 Vitórias</button>
            <button type="button" class="btn btn-secondary" onclick="filterByResult('Empate')">🤝 Empates</button>
            <button type="button" class="btn btn-secondary" onclick="filterByResult('Derrota')">💔 Derrotas</button>
            <button type="button" class="btn btn-secondary" onclick="filterRecent()">📅 Recentes</button>
            <button type="button" class="btn btn-secondary" onclick="clearFilters()">🗑️ Limpar Filtros</button>
        </div>

        <div class="mb-20">
            <input type="text" id="searchInput" placeholder="Buscar por time ou data (YYYY-MM-DD)..." 
                   value="<?php echo htmlspecialchars($busca); ?>" 
                   class="search-input"
                   onkeyup="filterTable()">
        </div>

        <script>
        function filterTable() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.querySelector("table");
            tr = table.getElementsByTagName("tr");
            
            for (i = 1; i < tr.length; i++) {
                tr[i].style.display = "";
                if (filter === "") continue;
                
                tr[i].style.display = "none";
                td = tr[i].getElementsByTagName("td");
                
                for (j = 0; j < td.length - 1; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        }
                    }
                }
            }
        }

        function filterByResult(resultado) {
            var table, tr, td, i;
            table = document.querySelector("table");
            tr = table.getElementsByTagName("tr");
            
            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[5]; 
                if (td) {
                    if (td.textContent.includes(resultado)) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
            document.getElementById("searchInput").value = "";
        }

        function filterRecent() {
            var table, tr, td, i, dataPartida, hoje, diffDias;
            table = document.querySelector("table");
            tr = table.getElementsByTagName("tr");
            hoje = new Date();
            
            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    var partes = td.textContent.split('/');
                    if (partes.length === 3) {
                        dataPartida = new Date(partes[2], partes[1] - 1, partes[0]);
                        diffDias = Math.floor((hoje - dataPartida) / (1000 * 60 * 60 * 24));
                        
                        if (diffDias <= 30) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
            document.getElementById("searchInput").value = "";
        }

        function clearFilters() {
            var tr = document.querySelectorAll("table tr");
            for (var i = 1; i < tr.length; i++) {
                tr[i].style.display = "";
            }
            document.getElementById("searchInput").value = "";
        }
        </script>

        <?php if (mysqli_num_rows($resultado) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Time Casa</th>
                        <th>Time Fora</th>
                        <th>Placar</th>
                        <th>Resultado</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($partida = mysqli_fetch_assoc($resultado)): 
                        $resultado_casa = '';
                        $classe_resultado = '';
                        if ($partida['gols_casa'] > $partida['gols_fora']) {
                            $resultado_casa = 'Vitória';
                            $classe_resultado = 'vitoria';
                        } elseif ($partida['gols_casa'] < $partida['gols_fora']) {
                            $resultado_casa = 'Derrota';
                            $classe_resultado = 'derrota';
                        } else {
                            $resultado_casa = 'Empate';
                            $classe_resultado = 'empate';
                        }
                    ?>
                    <tr>
                        <td><?php echo $partida['id']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($partida['data_jogo'])); ?></td>
                        <td><?php echo htmlspecialchars($partida['time_casa_nome']); ?></td>
                        <td><?php echo htmlspecialchars($partida['time_fora_nome']); ?></td>
                        <td class="resultado"><?php echo $partida['gols_casa'] . ' x ' . $partida['gols_fora']; ?></td>
                        <td class="<?php echo $classe_resultado; ?>"><?php echo $resultado_casa; ?></td>
                        <td class="actions">
                            <a href="update.partidas.php?id=<?php echo $partida['id']; ?>" class="btn btn-warning">✏️ Editar</a>
                            <a href="delete.partidas.php?id=<?php echo $partida['id']; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja deletar esta partida?')">🗑️ Deletar</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center mt-20" style="color: #666;">Nenhuma partida cadastrada.</p>
        <?php endif; ?>
    </div>
</body>
</html>
