<?php
session_start();
require_once 'cadastro.php'; // ou ajuste conforme o nome do seu arquivo de conexão

$id = $_POST['id'] ?? null;
$tipo = $_POST['tipo'] ?? null;

$cep = $_POST['cep'];
$logradouro = $_POST['logradouro'];
$numero = $_POST['numero'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];

if (!$id || !$tipo) {
    die('ID ou tipo de organização não informado.');
}

// Verifica se já existe um endereço para essa entidade
$sqlCheck = "SELECT id FROM enderecos WHERE tipo = ? AND id_referencia = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("si", $tipo, $id);
$stmtCheck->execute();
$stmtCheck->store_result();

if ($stmtCheck->num_rows > 0) {
    // Atualiza
    $sql = "UPDATE enderecos SET cep=?, logradouro=?, numero=?, bairro=?, cidade=?, estado=? WHERE tipo=? AND id_referencia=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $cep, $logradouro, $numero, $bairro, $cidade, $estado, $tipo, $id);
} else {
    // Insere
    $sql = "INSERT INTO enderecos (tipo, id_referencia, cep, logradouro, numero, bairro, cidade, estado)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissssss", $tipo, $id, $cep, $logradouro, $numero, $bairro, $cidade, $estado);
}

if ($stmt->execute()) {
    header('Location: cadastro_sucesso.php');
    exit;
} else {
    echo "Erro ao salvar endereço: " . $stmt->error;
}

$stmtCheck->close();
$stmt->close();
$conn->close();
?>