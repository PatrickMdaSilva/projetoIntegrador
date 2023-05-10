<?php
require_once("templates/header.php");

require_once("models/User.php");
require_once("dao/UserDAO.php");
require_once("dao/BookDAO.php");

$user = new User();
$userDao = new UserDAO($conn, $BASE_URL);

$userData = $userDao->verifyToken(true);
$fullName = $user->getFullName($userData);
$id = $userData->id_user;

$bookDao = new BookDAO($conn, $BASE_URL);
$lastBooks = $bookDao->wantBook($userData);


//Alterna entre número de telefone ou celular


//retorna a caixa do label ou dados que foram preenchidos


?>

<div id="main-container" class="container-fluid">
    <?php if ($lastBooks != null) { ?>
        <h2 class="section-title">Doação Solicitada</h2>
        <div class="book-container">
            <?php foreach ($lastBooks as $book) : ?>
                <div class="card book-card" style="margin-top: 15px;">
                    <div class="card-img-top" style="background-image: url('<?= $BASE_URL ?>img/books/<?= $book->image ?>');"></div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $book->name ?></h5>
                        <h5 class="card-title">Autor:<?= $book->author ?></h5>
                        <a href="">
                            <form action="<?= $BASE_URL ?>user_process.php" method="POST">
                                <input type="hidden" name="type" value="off-donate">
                                <input type="hidden" name="id" value="<?= $book->id_book ?>">
                                <input type="submit" value="interessado" class="">
                            </form>
                        </a>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php } else { ?>
        <h2 class="section-title">Nenhuma solicitação nesse momento.</h2>
    <?php } ?>
</div>