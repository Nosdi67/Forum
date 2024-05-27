<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class PostManager extends Manager {

    protected $className = "Model\Entities\Post";
    protected $tableName = "post";

public function __construct(){
        parent::connect();
    }

// Récupérer tous les posts d'un topic
    public function findPostsByTopicId($id) {
        
        $sql = "SELECT *
                FROM ".$this->tableName."
                WHERE topic_id = :id";

        return $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]),
            $this->className
        );
    }

    public function addPost($data) {
        $sql = "INSERT INTO post (text, topic_id) VALUES (:text, :topic_id)";
        DAO::insert($sql, $data);
    }

    public function updatePost($data){
        $sql="UPDATE ". $this->tableName." SET text = :text WHERE id_post = :id";
        DAO::insert($sql, ['text'=>$data["text"],'id'=>$data["id"]]);
    }
}
?>