<?php

class User
{
    private $id;

    private $email;

    private $password;

    private $role_id;

    private $session_id;

    public function getId()
    {
        return $this->id;
    }

    public function setEmail($email)
    {
        $this->id = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->id;
    }

    public function getRole_ID()
    {
        return $this->role_id;
    }

    public function getSession_ID()
    {
        return $this->session_id;
    }

    public static function Find($id)
    {
        $pdo = self::Connect();
        $stmt = $pdo->prepare("select * from ecommerce.users where id = :id");
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            return $stmt->fetchObject("User");
        } else {
            return false;
        }
    }

    public static function Create($params)
    {
        $pdo = self::Connect();
        $stmt = $pdo->prepare("insert into ecommerce.users (email,password, role_id) values (:email, :password, 1)");
        $stmt->bindParam(":email", $params["email"]);
        $stmt->bindParam(":password", $params["password"]);
        if ($stmt->execute()) {
            $stmt = $pdo->prepare("select * from ecommerce.users order by id desc limit 1");
            $stmt->execute();
            return $stmt->fetchObject("User");
        } else {
            throw new PDOException("Errore nella creazione!");
        }
    }

    public static function Connect()
    {
        return DbManager::Connect("ecommerce");
    }
}

?>