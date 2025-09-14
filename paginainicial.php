<?php
session_start();
// Verifica se o usuário está logado
if (!isset($_SESSION['vendedor_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'conexao.php';

// Consulta para buscar todos os produtos
$sql = "SELECT * FROM produtos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Papelaria PaperBloom</title>
  <!-- BOOTSTRAP -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <!-- FONT AWESOME -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Cherry+Cream+Soda&family=Festive&family=Joti+One&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Oi&family=Original+Surfer&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
</head>

<body>

  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#"></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Avisos</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Categorias
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Caderno</a></li>
              <li><a class="dropdown-item" href="#">Estojo</a></li>
              <li>
              <li><a class="dropdown-item" href="#">Mochila</a></li>
          </li>
          <li><a class="dropdown-item" href="#">Papelaria</a></li>
        </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" aria-disabled="true"></a>
        </li>
        </ul>
        <a class="navbar-brand" href="#" style="color: #20B2AA; "><b>Paper</b><b
            style="color: #DB7093;">Bloom❀</b></a><!-- Centraliza o título -->
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
          <button class="btn btn-outline-secondary" type="submit">Search</button>
        </form>

      </div>
    </div>
  </nav>
  <div class="main-content">
    <div class="container">
      <h3 class="bem-vindo">Bem vindo à PaperBloom❀!</h3><!--Estilizar-->
      <p class="avisos-imp-prod">Cadastrar Produto!</p>
      <div class="container mt-5" id="tabela-produto">
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
            <label for="tipo" class="form-label">Marca do produto</label>
            <input type="text" class="form-control" id="tipo" name="marca" placeholder="Ex: Faber-Castel" required>
          </div>
          <div class="col-md-2">
            <label for="preco" class="form-label">Preço</label>
            <input type="number" step="0.01" class="form-control" id="preco" name="preco" placeholder="R$ 0,00"
              required>
          </div>
          <div class="col-md-2">
            <label for="quantidade" class="form-label">Quantidade</label>
            <input type="number" class="form-control" id="quantidade" name="quantidade" placeholder="0" required>
          </div>
          <div class="col-md-12 d-flex" style="margin-left:40%;" >
            <button type="submit" class="btn btn-primary" style="align-items: center;">Adicionar Produto</button>
          </div>
        </form>
      </div>
    </div>
  </div>
   <h3 class="mt-5">Produtos em Estoque</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Preço</th>
                    <th scope="col">Quantidade</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["codigo"] . "</td>";
                        echo "<td>" . $row["tipo"] . "</td>";
                        echo "<td>" . $row["marca"] . "</td>";
                        echo "<td>R$ " . number_format($row["preco"], 2, ',', '.') . "</td>";
                        echo "<td>" . $row["quantidade"] . "</td>";
                        echo "<td><a href='editar_produto.php?id=" . $row["id"] . "' class='btn btn-sm btn-warning'>Editar</a> <a href='excluir_produto.php?id=" . $row["id"] . "' class='btn btn-sm btn-danger'>Excluir</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Nenhum produto cadastrado.</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>

  <!--- Fim dos cards--->
  </div>
  <!-- Main e Footer -->
  <footer>
    <p>© 2025 - Todos os direitos reservados</p>
    <a href="#contato">PaperBloom@gmail.com</a>
  </footer>


  <!-- BOOTSTRAP 4 script-->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
    integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
    integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
    crossorigin="anonymous"></script>
  <script>
    // Your custom JS code can go here
  </script>
</body>

</html>