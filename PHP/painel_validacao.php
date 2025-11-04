<?php
session_start();

// verifica se está logado e se é admin
if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'admin') {
    header('Location: ../PHP/login.php'); // redireciona para o login se não for admin
    exit;
}

require_once '../PHP/conexao.php'; // seu arquivo de conexao com o banco

// consulta usuários pendentes
$sql = "SELECT id, nome, email, tipo FROM usuarios WHERE status = 'pendente'";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Painel de Validação - Admin</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f4a261; color: white; }
        button { padding: 5px 10px; margin: 2px; cursor: pointer; }
        .aprovar { background-color: #2a9d8f; color: white; border: none; }
        .recusar { background-color: #e76f51; color: white; border: none; }
    </style>
</head>
<body>
    <h1 style="text-align:center;">Painel de Validação de Usuários</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Tipo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nome']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['tipo']) ?></td>
                    <td>
                        <form action="atualizar_status.php" method="GET" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <input type="hidden" name="acao" value="aprovar">
                            <button type="submit" class="aprovar">Aprovar</button>
                        </form>

                        <form action="atualizar_status.php" method="GET" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <input type="hidden" name="acao" value="recusar">
                            <button type="submit" class="recusar">Recusar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align:center;">Nenhum usuário pendente para validar.</p>
    <?php endif; ?>

</body>
</html>

<?php $conn->close(); ?>
