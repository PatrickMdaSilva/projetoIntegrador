<?php

require_once("models/Book.php");
require_once("models/Message.php");

class BookDAO implements BookDAOInterface{

    private $conn;
    private $url;
    private $message;

    public function __construct(PDO $conn, $url) {
        $this->conn = $conn;
        $this->url = $url;
        $this->message = new Message($url);
    } 

    public function construirBook($data){
        $book = new Book();

        $book->id_book = $data["id_book"];
        $book->name = $data["name"];
        $book->author = $data["author"];
        $book->edition = $data["edition"];
        $book->publish = $data["publish"];
        $book->ass = $data["ass"];
        $book->image = $data["image"];
        $book->donor = $data["donor"];
        $book->contact = $data["contact"];
        $book->flag = $data["flag"];
        $book->year = $data["year"];
        $book->id_user = $data["id_user"];
        

        return $book;
    }

    public function criarBook( Book $book, $userData){
        $stmt = $this->conn->prepare(
            "INSERT INTO books
                (name, author, edition, publish, ass, image, donor, contact, flag, year, id_user)
            VALUES
                (:name, :author, :edition, :publish, :ass, :image, :donor, :contact, :flag, :year, :id_user)"
        );
        
        $stmt->bindParam(":name", $book->name);
        $stmt->bindParam(":author", $book->author);
        $stmt->bindParam(":edition", $book->edition);
        $stmt->bindParam(":publish", $book->publish);
        $stmt->bindParam(":ass", $book->ass);
        $stmt->bindParam(":image", $book->image);
        $stmt->bindParam(":donor", $book->donor);
        $stmt->bindParam(":contact", $book->contact);
        $stmt->bindParam(":flag", $book->flag);
        $stmt->bindParam(":year", $book->year);
        $stmt->bindParam(":id_user", $userData->id_user);
    
        $stmt->execute();
    
        $this->message->setMessage("Dados cadastrados com sucesso!", "success","editprofile.php");
    }

    public function atualizarBook(Book $book, $userData)
    {
        $stmt = $this->conn->prepare(
            "UPDATE book SET
                postal_code = :postal_code,
                street = :street,
                district = :district,
                city = :city,
                state = :state
                WHERE id_user = :id_user
            ");

        $stmt->bindParam(":name", $book->name);
        $stmt->bindParam(":author", $book->author);
        $stmt->bindParam(":edition", $book->edition);
        $stmt->bindParam(":publish", $book->publish);
        $stmt->bindParam(":ass", $book->ass);
        $stmt->bindParam(":image", $book->image);
        $stmt->bindParam(":donor", $book->donor);
        $stmt->bindParam(":contact", $book->contact);
        $stmt->bindParam(":id_user", $userData->id_user);

         $this->message->setMessage("Dados cadastrados com sucesso!", "success","contact.php");
        }
        

        public function wantBook($userData){
            $books = [];
            $stmt = $this->conn->prepare(
                "SELECT * FROM books 
                 WHERE id_user = :id_user
                 AND flag = 1
                "
            );
            $stmt->bindParam(":id_user", $userData->id_user);
            $stmt->execute();
            
            if($stmt->rowCount() > 0) {
                $booksArry = $stmt->fetchAll();
                foreach($booksArry as $book) {
                    $books[] = $this->construirBook($book);
                }
                return $books;
            }
        }    
    public function buscarBook(){
        $books = [];
        $stmt = $this->conn->query(
            "SELECT * FROM books
             WHERE flag = 0
             ORDER BY id_book DESC"
        );
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $booksArry = $stmt->fetchAll();
            foreach($booksArry as $book) {
                $books[] = $this->construirBook($book);
            }
            return $books;
        }
    }

    
    public function solicitedBook($id){
        $flag = 1;
        $stmt = $this->conn->prepare(
            "UPDATE books SET
                flag = :flag
                WHERE id_book = $id
            ");
        $stmt->bindParam("flag", $flag);
        $stmt->execute();

        $this->message->setMessage("Dados cadastrados com sucesso!", "success","asservo.php");
        
    }
    
    public function decrepBook($id){
        $flag = 0;
        $stmt = $this->conn->prepare(
            "UPDATE books SET
                flag = :flag
                WHERE id_book = $id
            ");
        $stmt->bindParam("flag", $flag);
            
        $stmt->execute();
            
        $this->message->setMessage("Dados cadastrados com sucesso!", "success","flag.php");
    }
    public function destroyId($id){
        $stmt = $this->conn->prepare(
            "DELETE FROM books 
             WHERE id_book = :id_book"
        );
        $stmt->bindParam(":id_book", $id);
        $stmt->execute();
        
        $this->message->setMessage("Livro deletado sucesso!", "success","curriculo.php");
    }


    public function donorBook($userData){
        $books = [];
        $stmt = $this->conn->prepare(
            "SELECT * FROM books 
             WHERE id_user = :id_user
            "
        );
        $stmt->bindParam(":id_user", $userData->id_user);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $booksArry = $stmt->fetchAll();
            foreach($booksArry as $book) {
                $books[] = $this->construirBook($book);
            }
            return $books;
        }
    }

    public function imageGenerateName() {
        return bin2hex(random_bytes(60)) . ".jpg";
    }
}