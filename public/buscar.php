<?php
require_once("templates/header.php");

require_once("db.php");
require_once("models/User.php");
require_once("dao/UserDAO.php");


$user = new User();
$userDao = new UserDAO($conn, $BASE_URL);


$userData = $userDao->verifyToken(true);

