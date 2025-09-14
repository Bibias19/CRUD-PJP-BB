<?php
session_start();
if (!isset($_SESSION['vendedor_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'conexao.php';

$produto = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Busca o produto para preencher o formulário
    $sql = "SELECT * FROM produtos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $produto = $result->fetch_assoc();
    $stmt->close();

    if (!$produto) {
        echo "Produto não encontrado.";
        exit;
    }
}

// Processa a atualização
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $codigo = $_POST['codigo'];
    $tipo = $_POST['tipo'];
    $marca = $_POST['marca'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];

    $sql = "UPDATE produtos SET codigo = ?, tipo = ?, marca = ?, preco = ?, quantidade = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdi", $codigo, $tipo, $marca, $preco, $quantidade, $id);

    if ($stmt->execute()) {
        header("Location: paginainicial.php");
    } else {
        echo "Erro ao atualizar produto: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
... (inclua seus links para CSS e Bootstrap)
<body>
    <div class="card-form container mt-5 p-4 shadow-sm rounded">
        <h2>Editar Produto</h2>
        <form class="row g-3" action="editar_produto.php" method="post">
            <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">
            <div class="col-md-2">
                <label for="codigo" class="form-label">Código</label>
                <input type="text" class="form-control" id="codigo" name="codigo" value="<?php echo htmlspecialchars($produto['codigo']); ?>" required>
            </div>
            ... (campos para tipo, marca, preco, quantidade preenchidos com os valores do produto)
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                <a href="paginainicial.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>