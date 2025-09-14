<?php
session_start();
if (!isset($_SESSION['vendedor_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM produtos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: paginainicial.php");
    } else {
        echo "Erro ao excluir produto: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID do produto não fornecido.";
}
?>