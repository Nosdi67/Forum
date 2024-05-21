<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class UserManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\User";
    protected $tableName = "user";

    public function __construct(){
        parent::connect();
    }
    public function getUserId($id){
        $sql = "SELECT * 
        FROM ".$this->tableName." WHERE id = :id";
        
        return $this->getOneOrNullResult(
        DAO::select($sql, ['id' => $id]),
        $this->className);
    }

    public function addUser($data){
        $sql="INSERT INTO ".$this->tableName." (nickName, email, mdp) VALUES (:nickName, :email, :mdp)";
        DAO::insert($sql,$data);
    }

    public function findUserByNickName($nickName){
        $sql = "SELECT *
        FROM ".$this->tableName." WHERE nickName = :nickName";
    

        return $this->getOneOrNullResult(
            DAO::select($sql, ['nickName' => $nickName]),
            $this->className
        );
    }

    public function findUserByEmail($email){
        $sql = "SELECT *
        FROM ".$this->tableName." WHERE email = :email";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['email' => $email]),
            $this->className
        );
    }
}