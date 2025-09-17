<!--ja editado-->
<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname  = "paperbloom";


$conexao = new mysqli($servername, $username, $password, $dbname);

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}
$conexao->set_charset("utf8");
