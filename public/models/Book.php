<?php 

class Book {
    public $id_book;
    public $name;
    public $author;
    public $edition;
    public $publish;
    public $ass;
    public $image;
    public $donor;
    public $contact;
    public $flag;
    public $year;
    public $id_user;

}

interface BookDAOInterface {
    public function construirBook($data);
    public function criarBook( Book $book,$userData);
    public function atualizarBook(Book $book, $userData);
    public function wantBook($userData);
    public function buscarBook();
    public function donorBook($userData);
    public function solicitedBook($id);
    public function decrepBook($id);
    public function imageGenerateName();
    public function destroyId($id);

        
    


}