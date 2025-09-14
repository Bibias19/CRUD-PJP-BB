<?php
$servername = "localhost";
$username = "root"; // Substitua pelo seu nome de usuário do banco de dados
$password = ""; // Substitua pela sua senha
$dbname = "paperbloom_db"; // Nome do banco de dados que você criou

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
