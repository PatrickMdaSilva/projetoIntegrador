<?php

require_once("models/Information.php");
require_once("models/Message.php");

// information DAO

class InformationDAO implements InformationDAOInterface {

  private $conn;
  private $url;
  private $message;

  public function __construct(PDO $conn, $url){
    $this->conn = $conn;
    $this->url = $url;
    $this->message = new Message($url);

  }

  public function buildInformation($data){

        $information = new Information();

        $information->idemployes = $data["idemployes"];
        $information->nat = $data["nat"];
        $information->born = $data["born"];
        $information->city = $data["city"];
        $information->district = $data["district"];
        $information->cel = $data["cel"];
        $information->id_user = $data["id_user"];
        


        return $information;
  }

  public function update(Information $information){
    $stmt = $this->conn->prepare("UPDATE employes SET
      nat = :nat,
      born = :born,
      city = :city,
      district = :district,
      cel = :cel
      WHERE id_use = :id_user
      ");

    $stmt->bindParam(":nat", $information->nat);
    $stmt->bindParam(":born", $information->born);
    $stmt->bindParam(":city", $information->city);
    $stmt->bindParam(":district", $information->district);
    $stmt->bindParam(":cel", $information->cel);
    $stmt->bindParam(":id_user", $information->id_user);

    $stmt->execute();

    // Mensagem de sucesso
    $this->message->setMessage("Dados atualizados com sucesso!", "success", "editprofile.php");
  }

  public function getInformation(){
    
    $information = [];

    $stmt = $this->conn->prepare("SELECT employes.idemployes, employes.nat, employes.born, employes.city, employes.district, employes.cel, employes.id_user FROM employes INNER JOIN users ON employes.id_user = users.id");
    $stmt->execute();

    if($stmt->rowCount() > 0 ){
      $informationArray = $stmt->fetchAll();
      foreach($informationArray as $information) {
        $information[] = $this->buildInformation($information);
      }
    }
    return $information;
  }
  
}