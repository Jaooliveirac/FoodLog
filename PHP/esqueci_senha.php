<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/FoodLog/php/conexao.php';

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $nova_senha = $_POST['nova_senha'];
    $confirma_senha = $_POST['confirma_senha'];

    // Consulta usuário por email e CPF
    $sql = "SELECT id_usuario FROM usuarios WHERE email = ? AND cpf = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $cpf);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        if ($nova_senha !== $confirma_senha) {
            $mensagem = "Nova senha e confirmação não coincidem!";
        } else {
            $usuario = $resultado->fetch_assoc();
            $id_usuario = $usuario['id_usuario'];
            $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

            // Atualiza senha no banco
            $sql_update = "UPDATE usuarios SET senha = ? WHERE id_usuario = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("si", $nova_senha_hash, $id_usuario);
            $stmt_update->execute();

            $mensagem = "Senha alterada com sucesso! Agora faça login com a nova senha.";
        }
    } else {
        $mensagem = "Email ou CPF não encontrados.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Esqueci a Senha - FoodLog</title>
</head>
<body>
    <h2>Redefinir Senha</h2>

    <?php if ($mensagem) echo "<p>$mensagem</p>"; ?>

    <form method="POST" action="">
        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>CPF:</label>
        <input type="text" name="cpf" required><br>

        <label>Nova Senha:</label>
        <input type="password" name="nova_senha" required><br>

        <label>Confirmar Nova Senha:</label>
        <input type="password" name="confirma_senha" required><br>

        <button type="submit">Redefinir Senha</button>
    </form>
</body>
</html>
