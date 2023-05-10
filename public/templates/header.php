<?php
    require_once("globals.php");
    require_once("db.php");
    require_once("models/Message.php");
    require_once("dao/UserDAO.php");

    $message = new Message($BASE_URL);

    $flassMessage = $message->getMessage();

    if(!empty($flassMessage["msg"])) {
      //limpar a mensagem
      $message->clearMessage();
    }

    $userDao = new UserDAO($conn, $BASE_URL);

    $userData = $userDao->verifyToken(false);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content=""><!--Descrição do site-->
    <link rel="stylesheet" href="<?= $BASE_URL ?>css//bootstrap.min.css">
    <link rel="stylesheet" href="<?= $BASE_URL ?>css//style.css">
    <script src="js/bootstrap.min.js" defer></script>
    <script src="js/index.js" defer></script>
    <title>SDDL</title>
</head>
<body>
  <header>
      <nav class="navbar navbar-expand-lg" style="background-color:#49acf7;">
        <div class="container-fluid nav" id="nav-a">
          <a class="navbar-brand text-white col-2"  href="#">SDDL</a>
          <button class="navbar-toggler" style="background-color: #fff" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                  <a class="nav-link active text-white" aria-current="page" href="<?= $BASE_URL ?>index.php">Home</a>
            <?php if($userData): ?>
              <li class="nav-item">
                <a href="<?= $BASE_URL ?>curriculo.php"class="nav-link text-white bold">Livros</a>
              </li>
              <li class="nav-item">
                <a href="<?= $BASE_URL ?>flag.php"class="nav-link text-white"><i class="far fa-plus-square"></i>Doação</a>
              </li>
              <li class="nav-item">
                <a href="<?= $BASE_URL ?>editprofile.php"class="nav-link text-warning">
                  <b>Cadastrar Livro</b>
                </a>
              </li>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>logout.php"class="nav-link text-warning"><b>Logout</b></a>
            </li>
            <?php else: ?> 
              <li class="nav-item">
                <a class="nav-link text-white" href="<?= $BASE_URL ?>asservo.php">Acervo</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-white" href="<?= $BASE_URL ?>account.php">Cadastrar</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-white" href="<?= $BASE_URL ?>auth.php">Entrar</a>
              </li>
            <?php endif; ?>
            </ul>
          </div>
        </div>
      </nav>
  </header>
<?php if(!empty($flassMessage["msg"])) :?>
  <div class="msg-container">
    <p class="msg <?=$flassMessage["type"] ?>"><?= $flassMessage["msg"] ?></p>
  </div>
<?php endif; ?>  
