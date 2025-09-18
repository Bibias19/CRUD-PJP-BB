<?php
session_start();
if (!isset($_SESSION['id'])) {
  header("Location: logar.php");
  exit();
}
require_once 'conexao.php'; // MOVER para depois da verificação de sessão

// TESTE: Verificar se a conexão está funcionando
if ($conexao->connect_error) {
  die("Erro de conexão: " . $conexao->connect_error);
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
      </button>
    </div>
    <?php unset($_SESSION['message']); ?>
  <?php endif; ?>

  <div class="container my-5">
    <!-- Formulário de cadastro -->
    <h3>Adicionar Produto</h3>
    <form action="salvar_produto.php" method="POST" class="row g-3 mb-4" enctype="multipart/form-data">
      <div class="col-md-2">
        <label class="col-sm-3 col-form-label">Imagem</label>
        <div class="col-sm-6">
          <input type="file" class="form-control" name="imagem" accept="img/*" onchange="previewImage(event)">
          <img id="preview" src="img\Imagem indisponivel.png" style="max-width:120px;max-height:120px;margin-top:10px; ">
        </div>
      </div>
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
    <?php
    // VERIFICAR primeiro se a tabela existe
    $tableCheck = $conexao->query("SHOW TABLES LIKE 'produtos'");
    if ($tableCheck->num_rows == 0) {
      echo "<div class='alert alert-danger'>A tabela 'paperbloom' não existe no banco de dados.</div>";
    } else {
      // Consulta corrigida - verificar o nome exato da tabela
      $query = "SELECT id, imagem, codigo, tipo, marca, preco, quantidade FROM produtos";
      $result = $conexao->query($query);

      // DEBUG: Mostrar número de resultados
      echo "<div class='alert alert-info'>Produtos encontrados: " . $result->num_rows . "</div>";

      if ($result) {
        if ($result->num_rows > 0) {
    ?>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Imagem</th>
                <th>Código</th>
                <th>Tipo</th>
                <th>Marca</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                  <td><img src='imagem.php?id=<?= $row['id'] ?>' style='max-width:80px;max-height:80px;'></td>
                  <td><?php echo htmlspecialchars($row['codigo']); ?></td>
                  <td><?php echo htmlspecialchars($row['tipo']); ?></td>
                  <td><?php echo htmlspecialchars($row['marca']); ?></td>
                  <td><?php echo "R$ " . number_format($row['preco'], 2, ',', '.'); ?></td>
                  <td><?php echo $row['quantidade']; ?></td>
                  <td>
                    <a href="editar_produto.php?id=<?= $row['id']; ?>" class="btn btn-secondary">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="excluir_produto.php?id=<?= $row['id']; ?>" class="btn btn-danger">
                      <i class="fas fa-trash-alt"></i>
                    </a>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
    <?php
        } else {
          echo "<div class='alert alert-warning'>Nenhum produto cadastrado.</div>";
        }
      } else {
        echo "<div class='alert alert-danger'>Erro na consulta: " . $conexao->error . "</div>";
      }
    }
    $conexao->close();
    ?>
  </div>

  <!-- Footer -->
  <footer class="bg-light text-center py-3 mt-5">
    <p>© 2025 - Todos os direitos reservados</p>
    <a href="mailto:PaperBloom@gmail.com">PaperBloom@gmail.com</a>
  </footer>

  <script src="js/script.js"></script>
</body>

</html>

<?php
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
    $nome_arquivo = basename($_FILES['imagem']['name']);
    $caminho = 'img/' . $nome_arquivo;
    move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho);
} else {
    $caminho = 'img/Imagem indisponivel.png';
}
?>

<?php
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
    $imagem = file_get_contents($_FILES['imagem']['tmp_name']);
} else {
    $imagem = file_get_contents('img/Imagem indisponivel.png');
}
?>