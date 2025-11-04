<?php
// conexão com o banco
$conn = new mysqli('localhost', 'usuario', 'senha', 'foodlog');
if ($conn->connect_error) {
    die('Erro na conexão: ' . $conn->connect_error);
}

// dados do form
$nome_organizacao = $_POST['nome_organizacao'];
$nome_usuario = $_POST['nome_usuario'];
$cnpj = $_POST['cnpj'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$senha = $_POST['senha'];

// validações básicas
if (empty($nome_organizacao) || empty($nome_usuario) || empty($cnpj) || empty($email) || empty($telefone) || empty($senha)) {
    die('Por favor, preencha todos os campos.');
}

// validar e formatar senha (hash)
$senha_hashed = password_hash($senha, PASSWORD_BCRYPT);

// preprar e executar inserção da ONG ou Estabelecimento
if ($tipo === 'ong') {
    $stmt = $conn->prepare("INSERT INTO ongs (nome, cnpj, telefone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome_organizacao, $cnpj, $telefone);
} elseif ($tipo === 'estabelecimento') {
    $stmt = $conn->prepare("INSERT INTO estabelecimentos (nome_fantasia, cnpj, telefone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome_organizacao, $cnpj, $telefone);
} else {
    die('Tipo de cadastro inválido.');
}

if (!$stmt->execute()) {
    die('Erro ao inserir organização: ' . $stmt->error);
}

$id_organizacao = $stmt->insert_id; // id da ONG ou Estabelecimento criado

// inserir usuário vinculado
if ($tipo === 'ong') {
    $stmtUser = $conn->prepare("INSERT INTO usuarios (nome, email, senha, tipo, id_ong) VALUES (?, ?, ?, ?, ?)");
} else {
    $stmtUser = $conn->prepare("INSERT INTO usuarios (nome, email, senha, tipo, id_estabelecimento) VALUES (?, ?, ?, ?, ?)");
}

$stmtUser->bind_param("sssi", $nome_usuario, $email, $senha_hashed, $tipo, $id_organizacao);

if (!$stmtUser->execute()) {
    die('Erro ao inserir usuário: ' . $stmtUser->error);
}

$stmt->close();
$stmtUser->close();
$conn->close();

header('Location: ../HTML/cadastro-endereco.html');
exit;
?>