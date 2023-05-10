<?php
require_once("globals.php");
require_once("db.php");
require_once("models/User.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");

// instância a base da mensagem
$message = new Message($BASE_URL);

// instância a base do usuário
$userDao = new UserDAO($conn, $BASE_URL);

// Resgata o tipo do formulário

$type = filter_input(INPUT_POST, "type");

// Verificação do tipo de formulário
if ($type === "register") {
    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");
    $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

    // Verifica se um email é válido
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        // Verificação de dados mínimos
        if ($email && $password) {
            // Verifica se não está sendo usado caracteres especiais
            if ($password == $userDao->cleanText($password)) {

                // Verifica confirmacão de senha 
                if ($password === $confirmpassword) {

                    //Verificar se o email já esta registrado
                    if ($userDao->findByEmail($email) === false) {
                        $user = new User();

                        // Criação de token e senha
                        $userToken = $user->generateToken();
                        $finalPassword = $user->generatePassword($password);

                        $user->name = $name;
                        $user->lastname = $lastname;
                        $user->email = $email;
                        $user->password = $finalPassword;
                        $user->token = $userToken;

                        $auth = true;

                        $userDao->create($user, $auth);
                    } else {
                        //Envia mensagem de usuário já existente
                        $message->setMessage("Usuário já cadastrado tente outro e-mail", "error", "back");
                    }
                } else {
                    //Envia uma menssagem de erro de senhas
                    $message->setMessage("As senhas não são iguais.", "error", "back");
                }
            } else {
                $message->setMessage("Você utilizou caracteres não permitidos.", "error", "back");
            }
        } else {
            // Envia uma menssagem de erros de dados faltando
            $message->setMessage("Por favor, preencha todos os campos.", "error", "back");
        }
    } else {
        $message->setMessage("Insira um email em formato válido", "error", "back");
    }
} else if ($type === "login") {
    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");

    //tenta autenticar usuário
    if ($userDao->authenticateUser($email, $password)) {

        $message->setMessage("Olá Login realizado com sucesso!", "success", "editprofile.php");
        // Redirecionando o usuário, caso não conseguir autenticar    
    } else {
        $message->setMessage("Você já é cadastrado? Se for o usuário ou a senha estão incorretos!", "error", "back");
    }
} else {
    $message->setMessage("Informações inválidas!", "error", "index.php");
}
