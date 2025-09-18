<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "paperbloom";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Falha na conexão: " . $connection->connect_error);
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// CORREÇÃO: Mudar o nome da tabela de 'produtos' para 'paperbloom'
$sql = "SELECT imagem FROM produtos WHERE id = $id LIMIT 1";
$result = $connection->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    header("Content-Type: image/jpg");
    echo $row['imagem'];
} else {
    // Imagem padrão caso não encontre
    header("Content-Type: image/png");
    readfile("img/Imagem indisponivel.png"); // Use barra normal, não contra-barra
}
$connection->close();
