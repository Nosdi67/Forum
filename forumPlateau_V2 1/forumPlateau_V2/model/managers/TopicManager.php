<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class TopicManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Topic";
    protected $tableName = "topic";

    public function __construct(){
        parent::connect();
    }

    // récupérer tous les topics d'une catégorie spécifique (par son id)
    public function findTopicsByCategory($id) {

        $sql = "SELECT * 
                FROM ".$this->tableName." t 
                WHERE t.category_id = :id
                ORDER BY t.creationDate DESC";
       
        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );
    }
    public function findOneByTitle($title) {
        $sql = "SELECT *
                FROM ".$this->tableName." t
                WHERE t.title = :title";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['title' => $title]),
            $this->className
        );
    }

    public function addTopic($data) {
    
        $sql="INSERT INTO ".$this->tableName." (title, category_id) VALUES (:name,:category_id)";
        DAO::insert($sql,$data);
    }

    public function updateTopicStatus($data) {
        $sql="UPDATE ". $this->tableName." SET statut = :statut WHERE id_topic = :id";
        DAO::update($sql,['statut'=>$data["statut"],'id'=>$data["id"]]);
    }
    public function findTopicByUser($id) {
        $sql = "SELECT *
                FROM ".$this->tableName." t
                WHERE t.user_id = :id";

    return $this->getOneOrNullResult(
            DAO::select($sql, ['id' => $id],false),
            $this->className
        );
    }

    public function findTopicsByUser($id) {
        $sql = "SELECT *
                FROM ".$this->tableName." t
                WHERE t.user_id = :id";
        
        return  $this->getMultipleResults(
        DAO::select($sql, ['id' => $id]),
        $this->className
        );
        
    }

    public function findFeaturedTopics(){
        $sql = "SELECT t.id_topic, t.title, t.creationDate, COUNT(p.id_post) AS post_count
                FROM ".$this->tableName." t
                LEFT JOIN post p ON p.topic_id = t.id_topic
                GROUP BY t.id_topic
                ORDER BY post_count DESC
                LIMIT 6";
        return  $this->getMultipleResults(
        DAO::select($sql, null,true),
        $this->className
        );
    }
}