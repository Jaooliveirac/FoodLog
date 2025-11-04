<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/FoodLog/php/conexao.php';

if(isset($_SESSION['id_usuario'])) {
    // Remove token do banco
    if(isset($_COOKIE['remember_me'])) {
        $token = $_COOKIE['remember_me'];
        $stmt = $conn->prepare("DELETE FROM tokens_login WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();

        setcookie("remember_me", "", time()-3600, "/");
    }
}

// Destrói sessão
session_unset();
session_destroy();

header('Location: login.php');
exit;
?>
