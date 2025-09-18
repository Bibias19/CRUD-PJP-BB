<!--ja editado-->
<?php
session_start();
if (!isset($_SESSION['id'])) {
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
    $sql = "SELECT * FROM produtos WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            // Corrigir - variável $task sendo usada como $produto
            $produto = $result->fetch_assoc(); // Mudar nome da variável
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Papelaria PaperBloom</title>
  <!-- BOOTSTRAP 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="css/style-editar.css">
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#" style="color: #20B2AA;">
        <b>Paper</b><b style="color: #DB7093;">Bloom❀</b>
      </a>
    </div>
  </nav>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="card-form container mt-5 p-4 shadow-sm rounded">
        <h2>Editar Produto</h2>
        <form class="row g-3" action="update.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Imagem atual</label>
                <div class="col-sm-6 img-container">
                    <img src="imagem.php?id=<?php echo $id; ?>" alt="Imagem do produto" class="product-image">
                </div>
            </div>
            
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Nova imagem</label>
                <div class="col-sm-6">
                    <input type="file" class="form-control" name="imagem" accept="image/*">
                </div>
            </div>
            
            <div class="col-md-2 mb-3">
                <label for="codigo" class="form-label">Código</label>
                <input type="text" class="form-control" id="codigo" name="codigo" value="<?php echo $produto['codigo']; ?>" required>
            </div>
            
            <div class="col-md-3 mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <input type="text" class="form-control" id="tipo" name="tipo" value="<?php echo $produto['tipo']; ?>" required>
            </div>
            
            <div class="col-md-3 mb-3">
                <label for="marca" class="form-label">Marca</label>
                <input type="text" class="form-control" id="marca" name="marca" value="<?php echo $produto['marca']; ?>" required>
            </div>
            
            <div class="col-md-2 mb-3">
                <label for="preco" class="form-label">Preço</label>
                <div class="input-group">
                    <span class="input-group-text">R$</span>
                    <input type="number" step="0.01" class="form-control" id="preco" name="preco" value="<?php echo $produto['preco']; ?>" required>
                </div>
            </div>
            
            <div class="col-md-2 mb-3">
                <label for="quantidade" class="form-label">Quantidade</label>
                <input type="number" class="form-control" id="quantidade" name="quantidade" value="<?php echo $produto['quantidade']; ?>" required>
            </div>
            
            <div class="col-12 mt-4 button-group">
                <button id="salvar" type="submit" class="btn btn-primary">Salvar Alterações</button>
                <a id="cancelar" href="paginainicial.php" class="btn btn-primary">Cancelar</a>
            </div>
        </form>
    </div>
</body>

</html>