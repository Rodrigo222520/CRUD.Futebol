<?php
include_once 'db.times.php';

$busca = '';
$where = '';
if (isset($_GET['busca']) && !empty($_GET['busca'])) {
    $busca = mysqli_real_escape_string($conn, $_GET['busca']);
    $where = "WHERE nome LIKE '%$busca%' OR cidade LIKE '%$busca%'";
}

$sql = "SELECT * FROM times $where ORDER BY nome";
$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Times</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>
    <div class="container container-list">
        <h1>🏆 Lista de Times</h1>
        
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
            <a href="create.times.php" class="btn">➕ Adicionar Novo Time</a>
            <a href="../../index.php" class="back-btn">← Voltar ao Menu</a>
        </div>

        <div class="mb-20">
            <input type="text" id="searchInput" placeholder="Buscar por nome ou cidade..." 
                   value="<?php echo htmlspecialchars($busca); ?>" 
                   class="search-input"
                   onkeyup="filterTable()">
            <?php if (!empty($busca)): ?>
                <a href="read.times.php" class="btn btn-secondary mt-20">🗑️ Limpar</a>
            <?php endif; ?>
        </div>

        <script>
        function filterTable() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.querySelector("table");
            tr = table.getElementsByTagName("tr");
            
            for (i = 1; i < tr.length; i++) {
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
        
        <?php if (!empty($busca)): ?>
        document.addEventListener('DOMContentLoaded', function() {
            filterTable();
        });
        <?php endif; ?>
        </script>

        <?php if (mysqli_num_rows($resultado) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Cidade</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($time = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?php echo $time['id']; ?></td>
                        <td><?php echo htmlspecialchars($time['nome']); ?></td>
                        <td><?php echo htmlspecialchars($time['cidade']); ?></td>
                        <td class="actions">
                            <a href="update.times.php?id=<?php echo $time['id']; ?>" class="btn btn-warning">✏️ Editar</a>
                            <a href="delete.times.php?id=<?php echo $time['id']; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja deletar este time?')">🗑️ Deletar</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center mt-20" style="color: #666;">Nenhum time cadastrado.</p>
        <?php endif; ?>
    </div>
</body>
</html>
