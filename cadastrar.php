<!--ja editado-->
<?php
require_once 'conexao.php';
session_start();

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'] ?? null;
        $senha = $_POST['senha'] ?? null;
        $confirma_senha = $_POST['confirma_senha'] ?? null;

        if ($email && $senha && $confirma_senha) {
            if ($senha !== $confirma_senha) {
                throw new Exception("As senhas não coincidem.");
            }

            $hashed_password = password_hash($senha, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuarios (email, senha) VALUES (?, ?)";
            $stmt = $conexao->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("ss", $email, $hashed_password);
                if ($stmt->execute()) {
                    $_SESSION['message'] = 'Cadastro realizado com sucesso!';
                    $_SESSION['message_type'] = 'success';
                    header("Location: logar.php");
                    exit();
                } else {
                    throw new Exception("Erro ao cadastrar: " . $stmt->error);
                }
                $stmt->close();
            } else {
                throw new Exception("Erro ao preparar consulta: " . $conexao->error);
            }
        } else {
            throw new Exception("Preencha todos os campos.");
        }
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
} finally {
    $conexao->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papelaria PaperBloom</title>
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="css/style-cadastro.css">
    <!-- FONTES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cherry+Cream+Soda&family=Festive&family=Joti+One&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Oi&family=Original+Surfer&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light"><div class="container justify-content-center"><a class="navbar-brand" href="#" style="color: #20B2AA;"><b>Paper</b><b style="color: #DB7093;">Bloom❀</b></a></div></nav>< !-- Formulário de Cadastro --><div class="card-form container mt-5 p-4 shadow-sm rounded"><h2 class="mb-4">Cadastro</h2><form class="row g-3" action="register_logic.php" method="POST"><div class="col-md-12"><label for="inputEmail4" class="form-label">Email</label><input type="email" class="form-control" id="inputEmail4" name="email" placeholder="exemplo@email.com"
        required></div><div class="col-md-6"><label for="inputPassword4" class="form-label">Senha</label><input type="password" class="form-control" id="inputPassword4" name="senha" required></div><div class="col-md-6"><label for="inputPassword4" class="form-label">Confirme a senha</label><input type="password" class="form-control" id="inputPassword4" name="confirma_senha" required></div><div class="col-12"><button type="submit" class="btn btn-primary w-100"
        style="background-color: #20B2AA; border-color: #20B2AA;">Cadastrar</button></div></form><div id="link-cadastro" class="col-12 mt-3 text-center"><a href="logar.php">Já possui uma conta? <b style="color: #DB7093;">Faça login !</b></a></div></div></body></html>