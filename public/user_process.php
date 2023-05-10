<?php

require_once("globals.php");
require_once("db.php");
require_once("models/Message.php");
require_once("models/User.php");
require_once("models/Book.php");
require_once("dao/UserDAO.php");
require_once("dao/BookDAO.php");


$message = new Message($BASE_URL);
$userDao = new UserDAO($conn, $BASE_URL);

$bookDao = new BookDAO($conn, $BASE_URL);

//print_r($userInformation[6]);exit;

// Resgata o tipo do formulário
$type = filter_input(INPUT_POST, "type");

// Resgata dados do usuário
$userData = $userDao->verifyToken();

// Atualizar usuário
if ($type === "update") {

  // Receber dados do post
  $name = filter_input(INPUT_POST, "name");
  $lastname = filter_input(INPUT_POST, "lastname");

  if($name == $userDao->cleanName($name) && $lastname == $userDao->cleanName($lastname)){
    // Criar um novo objeto de usuário
    $user = new User();
    
    // Preencher os dados do usuário
    $userData->name = $name;
    $userData->lastname = $lastname;
    $userDao->update($userData);

  } else {
    $message->setMessage("Por favor, utilize apenas letras no nome e sobrenome.", "error","back");
  }


} else if ($type === "createBook") {
  // Receber dados do post
  $name = filter_input(INPUT_POST, "name");
  $author = filter_input(INPUT_POST, "author");
  $year = filter_input(INPUT_POST, "year");
  $edition = filter_input(INPUT_POST, "edition");
  $publish = filter_input(INPUT_POST, "publish");
  $ass = filter_input(INPUT_POST, "ass");
  $donor = filter_input(INPUT_POST, "donor");
  $contact = filter_input(INPUT_POST, "contact");

  $book = new Book();
    if(!empty($name) && !empty($contact)){

        $book->name = $name;
        $book->author = $author;
        $book->edition = $edition;
        $book->publish = $publish;
        $book->ass = $ass;
        $book->donor = $donor;
        $book->contact = $contact; 
        $book->flag = 0; 
        $book->year = $year; 
        $book->id_user = $userData->id_user;

      if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
      
        $image = $_FILES["image"];
        $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
      
        $ext = strtolower(substr($image['name'], -4));
      
        if (in_array($image["type"], $imageTypes)) {
        
          if ($ext == ".png") {
            $imageFile = imagecreatefrompng($image["tmp_name"]);
            $imageName = $bookDao->imageGenerateName();
          
          } else if ($ext == ".jpg") {
            $imageFile = imagecreatefromjpeg($image["tmp_name"]);
            $imageName = $bookDao->imageGenerateName();
          }else {
            $message->setMessage("Tipo inválido de imagem, escolha arquivo png ou jpg! Esse arquivo é " . $_FILES['image']['type'], "error", "back");          
          } 
        
          imagejpeg($imageFile, "./img/books/" . $imageName);
          $book->image = $imageName;
        }

      }

        $bookDao->criarBook($book, $userData);        
    }else {
      $message->setMessage("Preencha o nome do livro e o contato.", "error", "editprofile.php");
    }
    
} else if ($type === "delete") { 

    $id = filter_input(INPUT_POST, "id");
    
  if($id){
      
    $bookDao->destroyId($id); 
    
  }else {
      
    $message->setMessage("Informações inválidas.", "error", "index.php");
  }

} else if ($type === "on-donate") {    
    
  $id = filter_input(INPUT_POST, "id");

  if($id){
      
    $bookDao->solicitedBook($id); 
    
  }else {
      
    $message->setMessage("Informações inválidas.", "error", "index.php");
  }

} else if ($type === "off-donate") {    
    
  $id = filter_input(INPUT_POST, "id");

  if($id){
      
    $bookDao->decrepBook($id); 
    
  }else {
      
    $message->setMessage("Informações inválidas.", "error", "index.php");
  }

}