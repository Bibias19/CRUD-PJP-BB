<!--ja editado-->
<?php
require_once 'conexao.php';

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'] ?? null;
        $senha = $_POST['senha'] ?? null;
        $confirma_senha = $_POST['confirma_senha'] ?? null;

        if ($email && $senha && $confirma_senha) {
            if ($senha !== $confirma_senha) {
                throw new Exception("As senhas não coincidem.");
            }
            if (!$conexao || $conexao->connect_error) {
                throw new Exception("Conexão com bancos de dados não está ativa: " . $conexao->connect_error);
            }
            $hashed_password = password_hash($senha, PASSWORD_ARGON2I);
            $sql = "INSERT INTO usuarios (email, senha) VALUES (?, ?)";
            $stmt = $conexao->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ss",$email, $hashed_password);
                if ($stmt->execute()) {
                    session_start();
                    $_SESSION['message'] = 'Cadastro realizado com sucesso. Por favor, faça login.';
                    $_SESSION['message_type'] = 'primary';
                    header("Location: logar.php");
                    exit();
                } else {
                    throw new Exception("Erro ao executar o cadastro " . $stmt->error);
                }
                $stmt->close();
            } else {
                throw new Exception("Erro ao preparar a consulta: " . $conexao->error);
            }
        } else {
            throw new Exception("Email, senha e confirmação são obrigatórios.");
        }
    } else {
        throw new Exception("Método de requisição inválido.");
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    if (isset($conexao) && $conexao) {
        $conexao->close();
    }
}
?>