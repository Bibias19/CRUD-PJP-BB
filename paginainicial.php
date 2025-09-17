<!--ja editado-->
<?php
session_start();
if (!isset($_SESSION['id'])) {
  header("Location: logar.php");
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
  <link rel="stylesheet" href="css/style.css">
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
  <?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-<?= $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
      <?= $_SESSION['message'] ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <?php unset($_SESSION['message']); ?>
  <?php endif; ?>

  <div class="container my-5">
    <!-- Formulário de cadastro -->
    <h3>Adicionar Produto</h3>
    <form action="salvar_produto.php" method="POST" class="row g-3 mb-4">
      <div class="col-md-2">
        <label for="codigo" class="form-label">Código</label>
        <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Ex: 001" required>
      </div>
      <div class="col-md-3">
        <label for="tipo" class="form-label">Tipo do Produto</label>
        <input type="text" class="form-control" id="tipo" name="tipo" placeholder="Ex: Lápis grafite" required>
      </div>
      <div class="col-md-3">
        <label for="marca" class="form-label">Marca</label>
        <input type="text" class="form-control" id="marca" name="marca" placeholder="Ex: Faber-Castel" required>
      </div>
      <div class="col-md-2">
        <label for="preco" class="form-label">Preço</label>
        <input type="number" step="0.01" class="form-control" id="preco" name="preco" placeholder="R$ 0,00" required>
      </div>
      <div class="col-md-2">
        <label for="quantidade" class="form-label">Quantidade</label>
        <input type="number" class="form-control" id="quantidade" name="quantidade" placeholder="0" required>
      </div>
      <div class="col-12 d-flex justify-content-center mt-3">
        <button type="submit" class="btn btn-primary">Adicionar Produto</button>
      </div>
    </form>

    <!-- Tabela de produtos -->
    <h3 class="mt-5">Produtos em Estoque</h3>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Código</th>
          <th>Tipo</th>
          <th>Marca</th>
          <th>Preço</th>
          <th>Quantidade</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php
        require_once 'conexao.php';
        $query = "SELECT id, tipo, marca, preco, quantidade FROM paperbloom";
        $$result = $conexao->query($query);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
        ?>
            <tr>
              <td> <?php echo $row['codigo']; ?></td>
              <td> <?php echo $row['tipo']; ?></td>
              <td><?php echo $row['marca']; ?></td>
              <td><?php echo "R$ " . number_format($row['preco'], 2, ',', '.'); ?></td>
              <td><?php echo $row['quantidade']; ?></td>
              <td>
                <a href="editar_produto.php?id=<?= $row['id']; ?>" class="btn btn-secondary">
                  <i class="fas fa-marker"></i>
                </a>
                <a href="excluir_produto.php?id=<?= $row['id']; ?>" class="btn btn-danger">
                  <i class="far fa-trash-alt"></i>
                </a>
              </td>
            </tr>
        <?php
          }
        } else {
          echo "<tr><td colspan='6' class='text-center'>Nenhum produto cadastrado.</td></tr>";
        }
        $stmt->close();
        $conexao->close();
        ?>
      </tbody>
    </table>
  </div>

  <!-- Footer -->
  <footer class="bg-light text-center py-3 mt-5">
    <p>© 2025 - Todos os direitos reservados</p>
    <a href="mailto:PaperBloom@gmail.com">PaperBloom@gmail.com</a>
  </footer>
</body>

</html>