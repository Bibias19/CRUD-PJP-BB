<!--ja editado-->
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: logar.php");
    exit();
}

require_once 'conexao.php';
$id = isset($_GET['id']) ? $_GET['id'] : null;
if (!$id) {
    echo "ID do produto não fornecido.";
    $_SESSION['message'] = 'ID do produto não fornecido.';
    $_SESSION['message_type'] = 'danger';
    header('Location: paginainicial.php');
    exit();
}
try {
    $sql = "SELECT * FROM paperbloom WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $task = $result->fetch_assoc();
        } else {
            echo "Produto não encontrado.";
            exit();
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = 'Error preparing statement: ';
        $_SESSION['message_type'] = 'danger';
        header('Location: paginainicial.php');
        exit();
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="card-form container mt-5 p-4 shadow-sm rounded">
        <h2>Editar Produto</h2>
        <form class="row g-3" action="update.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">

            <div class="col-md-2">
                <label for="codigo" class="form-label">Código</label>
                <input type="text" class="form-control" id="codigo" name="codigo" value="<?php echo $produto['codigo']; ?>" required>
            </div>
            <div class="col-md-3">
                <label for="tipo" class="form-label">Tipo</label>
                <input type="text" class="form-control" id="tipo" name="tipo" value="<?php echo $produto['tipo']; ?>" required>
            </div>
            <div class="col-md-3">
                <label for="marca" class="form-label">Marca</label>
                <input type="text" class="form-control" id="marca" name="marca" value="<?php echo $produto['marca']; ?>" required>
            </div>
            <div class="col-md-2">
                <label for="preco" class="form-label">Preço</label>
                <input type="number" step="0.01" class="form-control" id="preco" name="preco" value="<?php echo $produto['preco']; ?>" required>
            </div>
            <div class="col-md-2">
                <label for="quantidade" class="form-label">Quantidade</label>
                <input type="number" class="form-control" id="quantidade" name="quantidade" value="<?php echo $produto['quantidade']; ?>" required>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                <a href="paginainicial.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>

</html>