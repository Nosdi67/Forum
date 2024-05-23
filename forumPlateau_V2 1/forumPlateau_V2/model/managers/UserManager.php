<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;
use App\Session;

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
    public function findImageByUserId($id){
        $sql = "SELECT image
        FROM ".$this->tableName." WHERE id_user = :id";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['id' => $id]),
            $this->className
        );
    }

    public function findUserByEmail($email){
        $sql = "SELECT *
        FROM ".$this->tableName." WHERE email = :email";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['email' => $email], false),
            $this->className
        );
    }

    public function updateUserNickName(){
        $sql = "UPDATE ".$this->tableName." SET nickName = :nickName WHERE id_user = :id";
        DAO::update($sql, ['nickName' => $_POST["nickName"],'id' => Session::getUser()->getId()]);
    }

    public function updateUserEmail(){
        $sql = "UPDATE ".$this->tableName." SET email = :email WHERE id_user = :id";
        DAO::update($sql, ['email' => $_POST["email"],'id' => Session::getUser()->getId()]);
    }

    public function updateUserMdp($data){
        $sql = "UPDATE ".$this->tableName." SET mdp = :mdp WHERE id_user = :id";
        DAO::update($sql, ['mdp' => $data["mdp"],'id' => Session::getUser()->getId()]);
    }

    public function updateUserImage($data){
        $sql = "UPDATE ".$this->tableName." SET image = :image WHERE id_user = :id";
        DAO::update($sql, ['image' => $data["image"],'id' => Session::getUser()->getId()]);
    }

   
}