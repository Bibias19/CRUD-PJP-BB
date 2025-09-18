<!--ja editado-->
<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: logar.php");
    exit;
}

require_once 'conexao.php';

try {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        // Corrigir - tabela errada
        $sql = "DELETE FROM produtos WHERE id = ?"; // Mudar de produtos para paperbloom
        $stmt = $conexao->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                session_start();
                $_SESSION['message'] = 'Produto Deletado com Sucesso';
                $_SESSION['message_type'] = 'success';

                header("Location: paginainicial.php");
                exit();
            } else {
                session_start();
                $_SESSION['message'] = 'Erro ao deletar produto';
                $_SESSION['message_type'] = 'danger';
                throw new Exception("Error executing query: " . $stmt->error);
            }
            $stmt->close();
        } else {
            throw new Exception("Error preparing statement: " . $conexao->error);
        }
    } else {
        throw new Exception("No ID provided for deletion.");
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    $conexao->close();
}
?>