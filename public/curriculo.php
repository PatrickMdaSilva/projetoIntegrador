<?php

require_once("templates/header.php");
//verifica se está logado
require_once("models/User.php");
require_once("models/Book.php");
require_once("dao/UserDAO.php");
require_once("dao/BookDAO.php");


$message = new Message($BASE_URL);
$userDao = new UserDAO($conn, $BASE_URL);
$bookDao = new BookDAO($conn, $BASE_URL);

//print_r($userInformation[6]);exit;

// Resgata dados do usuário
$userData = $userDao->verifyToken();
$lastBooks = $bookDao->donorBook($userData);


?>
<table class="table table-striped">
    <h2 style="text-align: center; margin-top: 50px;">Meus livros</h2>
    <trclass="table-active">
        <th>Nome do livro</th>
        <th>Autor</th>
        <th>Edição</th>
        <th>Editora</th>
        <th>Genero</th>
        <th>Doador</th>
        <th>Contato</th>
        <th>Registro</th>
        </tr>

        <?php if ($lastBooks != null) { ?>
            <?php foreach ($lastBooks as $book) : ?>
                <tr>
                    <td><?= $book->name ?></td>
                    <td><?= $book->author ?></td>
                    <td><?= $book->edition ?></td>
                    <td><?= $book->publish ?></td>
                    <td><?= $book->ass ?></td>
                    <td><?= $book->donor ?></td>
                    <td><?= $book->contact ?></td>
                    <td>
                        <form action="<?= $BASE_URL ?>user_process.php" method="POST">
                            <input type="hidden" name="type" value="delete">
                            <input type="hidden" name="id" value="<?= $book->id_book ?>">
                            <input type="submit" value="Deletar" class="">
                        </form>
                    </td>



                </tr>
            <?php endforeach; ?>
        <?php } ?>
</table>