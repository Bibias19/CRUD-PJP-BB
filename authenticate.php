<!--ja editado-->
<?php
require_once 'conexao.php';
try {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $email = isset($_POST['email']) ? $_POST['email'] : null;
        $senha = isset($_POST['senha']) ? $_POST['senha'] : null;
        if ($email && $senha) {
            $sql = "SELECT id, email, senha FROM usuarios WHERE email = ?";
            $stmt = $conexao->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows === 1) {
                    $usuarios = $result->fetch_assoc();
                    if (password_verify($senha, $usuarios['senha'])) {
                        // Password is correct, start a session
                        session_start();
                        $_SESSION['id'] = $usuarios['id'];
                        $_SESSION['email'] = $usuarios['email'];
                        $_SESSION['senha'] = $usuarios['senha'];
                        $_SESSION['message'] = 'Bem-vindo, ' . htmlspecialchars($usuarios['email']) . '!';
                        $_SESSION['message_type'] = 'primary';
                        header("Location: paginainicial.php");
                        exit();
                    } else {
                        throw new Exception("Email ou senha inválidos.");
                    }
                } else {
                    throw new Exception("Email ou senha inválidos.");
                }
                $stmt->close();
            } else {
                throw new Exception("erro ao preparar a consulta " . $conexao->error);
            }
        } else {
            throw new Exception("Email e senha são obrigatórios.");
        }
    } else {
        throw new Exception("Método de requisição inválido.");
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    $conexao->close();
}
?>