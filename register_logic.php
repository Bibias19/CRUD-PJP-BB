<?php
session_start(); // ✅ ADICIONADO: session_start() no TOPO
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
                throw new Exception("Conexão com banco de dados não está ativa: " . $conexao->connect_error);
            }
            $check_sql = "SELECT id FROM usuarios WHERE email = ?";
            $check_stmt = $conexao->prepare($check_sql);
            if ($check_stmt) {
                $check_stmt->bind_param("s", $email);
                $check_stmt->execute();
                $check_stmt->store_result();

                if ($check_stmt->num_rows > 0) {
                    throw new Exception("Este email já está cadastrado.");
                }
                $check_stmt->close();
            }

            $hashed_password = password_hash($senha, PASSWORD_ARGON2I);
            $sql = "INSERT INTO usuarios (email, senha) VALUES (?, ?)";
            $stmt = $conexao->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("ss", $email, $hashed_password);

                if ($stmt->execute()) {
                    $_SESSION['message'] = 'Cadastro realizado com sucesso. Por favor, faça login.';
                    $_SESSION['message_type'] = 'success';
                    header("Location: logar.php");
                    exit(); // ✅ ESSENCIAL
                } else {
                    throw new Exception("Erro ao cadastrar: " . $stmt->error);
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
    $_SESSION['message'] = $e->getMessage();
    $_SESSION['message_type'] = 'danger';
    header("Location: cadastrar.php");
    exit();
} finally {
    if (isset($conexao) && $conexao) {
        $conexao->close();
    }
}
