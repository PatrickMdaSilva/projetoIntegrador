<?php
    class User {
        public $id_user;
        public $name;
        public $lastname;
        public $email;
        public $password;
        public $token;
        
        
        
        public function getfullName($user) {
            return $user->name . " " . $user->lastname;
        }

        public function generateToken() {
            return bin2hex(random_bytes(50));
        }

        public function generatePassword($password) {
            return password_hash($password, PASSWORD_DEFAULT);
        }


    }

    interface UserDAOInterface {

        public function cleanLetter($str);
        public function cleanText($str);
        public function cleanName($str);
        public function cleanCurriculum($str);
        public function buildUser($data);
        public function create(User $user, $authUser = false);
        public function update(User $user, $redirect = true);
        public function verifyToken($protected = false);
        public function setTokenSession($token, $redirect = true);
        public function authenticateUser($email, $password);
        public function findByEmail($email);
        public function findById($id);
        public function findByToken($token);
        public function destroyToken();
        public function changePassword(User $user);
          
    }