<!-- Ja editado -->

<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: logar.php");
    exit;
}

require_once 'conexao.php';

try {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $codigo = isset($_POST['codigo']) ? trim($_POST['codigo']) : null;
        $tipo = isset($_POST['tipo']) ? trim($_POST['tipo']) : null;
        $marca = isset($_POST['marca']) ? trim($_POST['marca']) : null;
        $preco = isset($_POST['preco']) ? filter_var($_POST['preco'], FILTER_VALIDATE_FLOAT) : null;
        $quantidade = isset($_POST['quantidade']) ? filter_var($_POST['quantidade'], FILTER_VALIDATE_INT) : null;

        // Validação dos campos obrigatórios
        if ($codigo && $tipo && $marca && $preco !== false && $quantidade !== false) {
            $sql = "INSERT INTO paperbloom (codigo, tipo, marca, preco, quantidade) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conexao->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("sssdi", $codigo, $tipo, $marca, $preco, $quantidade);
                if ($stmt->execute()) {
                    $_SESSION['message'] = 'Produto Salvo com Sucesso';
                    $_SESSION['message_type'] = 'success';
                    header("Location: paginainicial.php");
                    exit();
                } else {
                    $_SESSION['message'] = 'Erro ao salvar produto';
                    $_SESSION['message_type'] = 'danger';
                    throw new Exception("Error executing query: " . $stmt->error);
                }
                $stmt->close();
            } else {
                throw new Exception("Error preparing statement: " . $conexao->error);
            }
        } else {
            throw new Exception("Todos os campos são obrigatórios e válidos.");
        }
    } else {
        throw new Exception("Invalid request method.");
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    $conexao->close();
}
