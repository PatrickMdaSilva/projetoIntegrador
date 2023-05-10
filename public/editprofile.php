<?php
require_once("templates/header.php");

require_once("models/User.php");
require_once("dao/UserDAO.php");

$user = new User();
$userDao = new UserDAO($conn, $BASE_URL);


$userData = $userDao->verifyToken(true);
$fullName = $user->getFullName($userData);
//$id = $userData->id_user;





?>

<div id="main-container" class="container-fluid ">
  <div id="main-container" class="container-fluid">
    <div class="col-md-12">
      <div class="row" id="auth-row">
        <div class="col-md-4" id="register-container">
          <form action="<?= $BASE_URL ?>user_process.php" method="POST" enctype="multipart/form-data" style="margin-top: 0;">
            <input type="hidden" name="type" value="update">
            <h2>Usuário</h2>
            <div class="form-group">
              <label for="email">Conta vinculada</label>
              <input type="text" readonly class="form-control disabled" id="email" name="email" value="<?= $userData->email ?>">
            </div>
            <div class="form-group">
              <label for="name">Nome:</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Digite o seu nome" value="<?= $userData->name ?>">
            </div>
            <div class="form-group">
              <label for="lastname">Sobrenome:</label>
              <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Digite o seu nome" value="<?= $userData->lastname ?>">
            </div>
            <input type="submit" class="btn card-btn" value="Editar">
          </form>
        </div>
        <div class="col-md-4" id="register-container">
          <form action="<?= $BASE_URL ?>user_process.php" method="POST" enctype="multipart/form-data" style="margin-top: 0;">
            <input type="hidden" name="type" value="createBook">
            <h2>Cadastrar livro</h2>
            <div class="form-group">
              <label for="name">Nome do livro:</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Digite o nome do livro" value="">
            </div>
            <div class="form-group">
              <label for="ass">Estante:</label>
              <select class="form-select" aria-label="Default select example" name="ass" id="ass">
                <option selected value=""></option>
                <option value="Ação">Ação</option>
                <option value="Aventura">Avantura</option>
                <option value="Comédia">Comédia</option>
                <option value="Drama">Drama</option>
                <option value="Didatico">Didático</option>
                <option value="Fantasia">Fantasia</option>
                <option value="Ficção">Ficção</option>
                <option value="Gibi">Gibi</option>
                <option value="Infantil">Infantil</option>
                <option value="Romance">Romance</option>
                <option value="Revista">Revista</option>
                <option value="Suspense">Suspense</option>
                <option value="Terror">Terror</option>
              </select>
            </div>
            <div class="form-group">
              <label for="author">Autor:</label>
              <input type="text" class="form-control" id="author" name="author" placeholder="Digite o author do livro" value="">
            </div>
            <div class="form-group">
              <label for="year">Data:</label>
              <input type="date" class="form-control" id="year" name="year" placeholder="Escolha a data de publicação" value="">
            </div>
            <div class="form-group">
              <label for="edition">Edição:</label>
              <input type="text" class="form-control" id="edition" name="edition" placeholder="Digite número da edição" value="">
            </div>
            <div class="form-group">
              <label for="name">Editora:</label>
              <input type="text" class="form-control" id="publish" name="publish" placeholder="Digite o nome da editora " value="">
            </div>
            <div class="form-group">
              <label for="name">Nome do doador:</label>
              <input type="text" class="form-control" id="donor" name="donor" placeholder="Digite seu nome" value="<?= $fullName ?>">
            </div>
            <div class="form-group">
              <label for="contact">Contato do doador:</label>
              <input type="text" class="form-control" id="contact" name="contact" placeholder="Digite o número do celular" value="">
            </div>
            <div class="form-group">
              <label for="image">Foto:</label>
              <input type="file" class="form-control-file" name="image">
            </div>
            <input type="submit" class="btn card-btn" value="Editar">
          </form>
        </div>
      </div>
    </div>
  </div>
