<?php
session_start();
// Verifica se o usuário está logado
if (!isset($_SESSION['vendedor_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo'];
    $tipo = $_POST['tipo'];
    $marca = $_POST['marca']; 
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];

    $sql = "INSERT INTO produtos (codigo, tipo, marca, preco, quantidade) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdi", $codigo, $tipo, $marca, $preco, $quantidade);

    if ($stmt->execute()) {
        header("Location: paginainicial.php");
    } else {
        echo "Erro ao adicionar produto: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>