<?php

class Session
{
    private $id;

    private $ip;

    private $data_login;

    private $data_logout;

    private $finished;

    public function getId()
    {
        return $this->id;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    public function getDataLogin()
    {
        return $this->data_login;
    }

    public function setDataLogin($data_login)
    {
        $this->data_login = $data_login;
    }

    public function getDataLogout()
    {
        return $this->data_logout;
    }

    public function setDataLogout($data_logout)
    {
        $this->data_logout = $data_logout;
    }

    public function getFinished()
    {
        return $this->finished;
    }

    public function setFinished($finished)
    {
        $this->finished = $finished;
    }

    public static function Create($params)
    {
        $pdo = self::Connect();
        $stmt = $pdo->prepare("insert into ecommerce.sessions (ip, data_login, data_logout, finished, user_id) values (:ip, :data_login, null, 0 , :user_id)");
        $stmt->bindParam(":ip", $params["ip"]);
        $stmt->bindParam(":data_login", $params["data_login"]);
        $stmt->bindParam(":user_id", $params["user_id"]);
        if ($stmt->execute()) {
            $stmt = $pdo->prepare("select * from ecommerce.sessions order by id desc limit 1");
            $stmt->execute();
            return $stmt->fetchObject("Session");
        } else {
            throw new PDOException("Errore nella creazione!");
        }
    }

    public function Update()
    {
        $pdo = self::Connect();
        $id = $this->getId();
        $data_logout = $this->getDataLogout();
        $finished = $this->getFinished();

        $stmt = $pdo->prepare("update ecommerce.sessions set data_logout = :data_logout, finished = :finished where id = :id");
        $stmt->bindParam(":data_logout", $data_logout);
        $stmt->bindParam(":finished", $finished);
        $stmt->bindParam(":id", $id);

        if (!$stmt->execute()) {
            throw new PDOException("Errore nell'aggiornamento del record di sessione!");
        }
    }

    public function Delete()
    {
        $pdo = self::Connect();
        $id = self::getId();
        $stmt = $pdo->prepare("delete from ecommerce.sessions where id = :id");
        $stmt->bindParam(":id", $id);
        if (!$stmt->execute()) {
            throw new PDOException("Errore nell'eliminazione del record di sessione!");
        }
    }

    public static function Find($id)
    {
        $pdo = self::Connect();
        $stmt = $pdo->prepare("select * from ecommerce.sessions where id = :id");
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            return $stmt->fetchObject("Session");
        } else {
            return false;
        }
    }

    public static function Connect()
    {
        return DbManager::Connect("ecommerce");
    }
}

?>