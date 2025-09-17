<!--ja editado-->
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Papelaria PaperBloom/login</title>
  <!-- BOOTSTRAP -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <!-- FONT AWESOME -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/style-login.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cherry+Cream+Soda&family=Festive&family=Joti+One&family=Montserrat:wght@400;700&family=Oi&family=Original+Surfer&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container justify-content-center">
      <a class="navbar-brand" href="#" style="color: #20B2AA;">
        <b>Paper</b><b style="color: #DB7093;">Bloom❀</b>
      </a>
    </div>
  </nav>
  <div class="container">
    <!--Session Message-->
    <?php if (isset($_SESSION['message'])): ?>
      <div class="alert alert-<?= $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
        <?= $_SESSION['message'] ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php unset($_SESSION['message']); ?>
    <?php endif ?>
    <div class="card-form">
      <h2>Login</h2>
      <form class="row g-3" method="POST" action="authenticate.php">
        <div class="col-md-12">
          <label for="inputEmail4" class="form-label">Email</label>
          <input type="email" class="form-control" id="inputEmail4" name="email" required>
        </div>
        <div class="col-md-12">
          <label for="inputPassword4" class="form-label">Senha</label>
          <input type="password" class="form-control" id="inputPassword4" name="senha" required>
        </div>
        <div class="col-12">
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
        <div class="col-12" id="link-cadastro">
          <a href="cadastrar.php">Não possui uma conta? Cadastre-se</a>
        </div>
      </form>
    </div>
</body>

</html>