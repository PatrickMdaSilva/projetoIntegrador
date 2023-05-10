<?php
require_once("models/User.php");
require_once("models/Message.php");

class UserDAO implements UserDAOInterface
{

    private $conn;
    private $url;
    private $message;

    public function __construct(PDO $conn, $url)
    {
        $this->conn = $conn;
        $this->url = $url;
        $this->message = new Message($url);
    }

    public function cleanLetter($str)
    { 
        return preg_replace("/[^0-9]/", "", $str); 
    }

    public function cleanText($str)
    { 
        return preg_replace("/[^A-Za-z0-9]/", "", $str); 
    }

    public function cleanName($str)
    { 
        return preg_replace("/[^A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ ]/", "", $str); 
    }

    public function cleanCurriculum($str)
    { 
        return preg_replace("/[^A-Za-z0-9áàâãéèêíïóôõöúçñÁÀÂÃÉÊÈÍÏÓÔÕÖÚÇÑ \s]/", "", $str); 
    }

    public function buildUser($data)
    {

        $user = new User();

       
        $user->id_user = $data["id_user"];
        $user->name = $data["name"];
        $user->lastname = $data["lastname"];
        $user->email = $data["email"];
        $user->password = $data["password"];
        $user->token = $data["token"];
        
        return $user;
    }

    public function create(User $user, $authUser = false)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO users
                (name, lastname, email, password, token)
            VALUES
                (:name, :lastname, :email, :password, :token)"
        );
        
        $stmt->bindParam(":name", $user->name);
        $stmt->bindParam(":lastname", $user->lastname);
        $stmt->bindParam(":email", $user->email);
        $stmt->bindParam(":password", $user->password);
        $stmt->bindParam(":token", $user->token);
    
        $stmt->execute();

        if($authUser){
            $this->setTokenSession($user->token);
        }

        $id_user = $this->conn->lastInsertId();

    }

    public function update(User $user, $redirect = true)
    {
        $stmt = $this->conn->prepare("UPDATE users SET
                name = :name,
                lastname = :lastname,
                email = :email,
                token = :token
                WHERE id_user = :id_user
            ");

        $stmt->bindParam(":name", $user->name);
        $stmt->bindParam(":lastname", $user->lastname);
        $stmt->bindParam(":email", $user->email);
        $stmt->bindParam(":token", $user->token);
        $stmt->bindParam(":id_user", $user->id_user);

        $stmt->execute();

        if ($redirect) {
            // Redireciona para o perfil do usuário
            $this->message->setMessage("Dados atualizados com sucesso!", "success", "editprofile.php");
        }
    }

    public function verifyToken($protected = false)
    {
        if (!empty($_SESSION["token"])) {

            // Pega o token da session
            $token = $_SESSION["token"];
            $user = $this->findByToken($token);

            if ($user) {
                return $user;
            } else if ($protected) {
                // Redireciona usuário não autenticado
                $this->message->setMessage("Faça a autenticação para acessar esta página", "error", "index.php");
            }
        } else if ($protected) {
            // Redireciona usuário não autenticado
            $this->message->setMessage("Faça a autenticação para acessar esta página", "error", "index.php");
        }
    }

    public function setTokenSession($token, $redirect = true)
    {
        // Salvar token na session
        $_SESSION["token"] = $token;

        if ($redirect) {
            // Redireciona para o perfil do usuário
            $this->message->setMessage("Seja bem vindo!", "success", "editprofile.php");
        }
    }

    public function authenticateUser($email, $password)
    {
        $user = $this->findByEmail($email);
        if ($user) {
            // Checa se as senhas batem
            if (password_verify($password, $user->password)) {
                // Gerar um token e inserir na sessão
                $token = $user->generateToken();
                $this->setTokenSession($token, false);

                // Atualizar token no usuário
                $user->token = $token;
                $this->update($user, false);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function findByEmail($email)
    {
        if ($email != "") {

            $stmt = $this->conn->prepare("SELECT *FROM users WHERE email = :email");
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch();
                $user = $this->buildUser($data);
                return $user;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function findById($id)
    {
    }

    public function findByToken($token)
    {
        if ($token != "") {

            $stmt = $this->conn->prepare("SELECT *FROM users WHERE token = :token");
            $stmt->bindParam(":token", $token);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch();
                $user = $this->buildUser($data);
                return $user;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function destroyToken()
    {
        //Remove token da sessão
        $_SESSION["token"] = "";

        //Redirecionar e apresentar a mensagem de sucesso
        $this->message->setMessage("Você fez o logout com sucesso!", "success", "index.php");
    }

    public function changePassword(User $user)
    {
        $stmt = $this->conn->prepare("UPDATE users SET

            password = :password
            where id = :id
            ");

        $stmt->bindParam(":password", $user->password);
        $stmt->bindParam(":id", $user->id_user);

        $stmt->execute();

        //Redirecionar e apresentar a mensagem de sucesso
        $this->message->setMessage("Senha alterada com sucesso", "success", "editprofile.php");
    }

    public function recoverPassword(){

    }
}
