<?php
require_once("templates/header.php");
?>
<div id="main-container"class="container-fluid ">
    <div id="main-container" class="container-fluid">
        <div class="col-md-12">
            <div class="row" id="auth-row">
                <div class="col-md-4" id="login-container">
                    <h2>Recuperar Senha</h2>
                    <form action="<?= $BASE_URL ?>auth_process.php" method="POST">
                    <input type="hidden" name="type" value="forgetemail">
                        <div class="form-group">
                            <label for="email">E-mail cadastrado:</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Digite seu e-mail">
                        </div>
                    <input type="submit" value="Enviar" class="btn card-btn">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
