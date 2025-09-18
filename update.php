<!--ja editado-->
<?php 
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: logar.php");
    exit();
}
require_once 'conexao.php';

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = intval($_POST['id']);
        $codigo = trim($_POST['codigo']);
        $tipo = trim($_POST['tipo']);
        $marca = trim($_POST['marca']);
        $preco = filter_var($_POST['preco'], FILTER_VALIDATE_FLOAT);
        $quantidade = filter_var($_POST['quantidade'], FILTER_VALIDATE_INT);

        if ($id && $codigo && $tipo && $marca && $preco !== false && $quantidade !== false) {
            $sql = "UPDATE produtos SET codigo=?, tipo=?, marca=?, preco=?, quantidade=? WHERE id=?";
            $stmt = $conexao->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ssssdi", $codigo, $tipo, $marca, $preco, $quantidade, $id);
                if ($stmt->execute()) {
                    $_SESSION['message'] = 'Produto atualizado com sucesso!';
                    $_SESSION['message_type'] = 'primary';
                    header("Location: paginainicial.php");
                    exit();
                } else {
                    $_SESSION['message'] = 'Erro ao atualizar produto.';
                    $_SESSION['message_type'] = 'danger';
                    throw new Exception("Erro ao executar a query: " . $stmt->error);
                }
                $stmt->close();
            } else {
                throw new Exception("Erro ao preparar o statement: " . $conexao->error);
            }
        } else {
            throw new Exception("Todos os campos são obrigatórios e válidos.");
        }
    } else {
        throw new Exception("Invalid request method.");
    }
} catch (Exception $e) {
    $_SESSION['message'] = 'Error: ' . $e->getMessage();
    $_SESSION['message_type'] = 'danger';
    header('Location: paginainicial.php');
    exit();
} finally {
    $conexao->close();
}
?>