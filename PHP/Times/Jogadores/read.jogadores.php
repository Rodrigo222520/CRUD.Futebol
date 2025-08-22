<?php
include_once 'db.jogadores.php';

$busca = '';
$where = '';
if (isset($_GET['busca']) && !empty($_GET['busca'])) {
    $busca = mysqli_real_escape_string($conn, $_GET['busca']);
    $where = "WHERE j.nome LIKE '%$busca%' OR j.posicao LIKE '%$busca%' OR t.nome LIKE '%$busca%'";
}

$sql = "SELECT j.*, t.nome as nome_time 
        FROM jogadores j 
        LEFT JOIN times t ON j.time_id = t.id 
        $where
        ORDER BY j.nome";
$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Jogadores</title>
    <link rel="stylesheet" href="../../../style.css">
</head>
<body>
    <div class="container container-list">
        <h1>⚽ Lista de Jogadores</h1>
        
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
            <a href="adicionar_jogador.php" class="btn btn-primary">
                ➕ Adicionar Novo Jogador
            </a>
            <a href="../../../index.php" class="back-btn">← Voltar ao Menu</a>
        </div>

        <div class="filter-buttons">
            <button type="button" class="btn btn-secondary" onclick="filterByPosition('GOL')">🥅 Goleiros</button>
            <button type="button" class="btn btn-secondary" onclick="filterByPosition('ZAG')">🛡️ Zagueiros</button>
            <button type="button" class="btn btn-secondary" onclick="filterByPosition('LAT')">🏃 Laterais</button>
            <button type="button" class="btn btn-secondary" onclick="filterByPosition('VOL')">🧹 Volantes</button>
            <button type="button" class="btn btn-secondary" onclick="filterByPosition('MEI')">🎯 Meias</button>
            <button type="button" class="btn btn-secondary" onclick="filterByPosition('ATA')">⚽ Atacantes</button>
            <button type="button" class="btn btn-danger" onclick="clearFilters()">🗑️ Limpar Filtros</button>
        </div>

        <div class="mb-20">
            <input type="text" id="searchInput" placeholder="Buscar por nome, posição ou time..." 
                   value="<?php echo htmlspecialchars($busca); ?>" 
                   class="search-input"
                   onkeyup="filterTable()">
        </div>

        <script>
        function filterTable() {
            var input = document.getElementById("searchInput");
            var filter = input.value.toUpperCase();
            var table = document.querySelector("table");
            var tr = table.getElementsByTagName("tr");
            
            for (var i = 1; i < tr.length; i++) {
                tr[i].style.display = "none";
                var td = tr[i].getElementsByTagName("td");
                for (var j = 0; j < td.length - 1; j++) {
                    if (td[j]) {
                        var txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        }
                    }
                }
            }
        }

        function filterByPosition(posicao) {
            var table = document.querySelector("table");
            var tr = table.getElementsByTagName("tr");
            for (var i = 1; i < tr.length; i++) {
                var td = tr[i].getElementsByTagName("td")[2];
                if (td) {
                    tr[i].style.display = td.textContent.includes(posicao) ? "" : "none";
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
                        <th>Nome</th>
                        <th>Posição</th>
                        <th>Nº Camisa</th>
                        <th>Time</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($jogador = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?php echo $jogador['id']; ?></td>
                        <td><?php echo htmlspecialchars($jogador['nome']); ?></td>
                        <td><?php echo htmlspecialchars($jogador['posicao']); ?></td>
                        <td><?php echo $jogador['numero_camisa']; ?></td>
                        <td><?php echo $jogador['nome_time'] ? htmlspecialchars($jogador['nome_time']) : 'Sem time'; ?></td>
                        <td class="actions">
                            <a href="update.jogadores.php?id=<?php echo $jogador['id']; ?>" class="btn btn-warning">✏️ Editar</a>
                            <a href="delete.jogadores.php?id=<?php echo $jogador['id']; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este jogador?')">🗑️ Excluir</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center mt-20" style="color: #666;">Nenhum jogador cadastrado.</p>
        <?php endif; ?>
    </div>
</body>
</html>
