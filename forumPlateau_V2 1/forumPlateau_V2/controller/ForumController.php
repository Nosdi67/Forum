<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;

class ForumController extends AbstractController implements ControllerInterface{

    public function index() {
        
        // créer une nouvelle instance de CategoryManager
        $categoryManager = new CategoryManager();
        // récupérer la liste de toutes les catégories grâce à la méthode findAll de Manager.php (triés par nom)
        $categories = $categoryManager->findAll(["name", "DESC"]);

        // le controller communique avec la vue "listCategories" (view) pour lui envoyer la liste des catégories (data)
        return [
            "view" => VIEW_DIR."forum/listCategories.php",
            "meta_description" => "Liste des catégories du forum",
            "data" => [
                "categories" => $categories
            ]
        ];
    }

    public function listTopicsByCategory($id) {

        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();
        $category = $categoryManager->findOneById($id);
        $topics = $topicManager->findTopicsByCategory($id);

        return [
            "view" => VIEW_DIR."forum/listTopics.php",
            "meta_description" => "Liste des topics par catégorie : ".$category,
            "data" => [
                "category" => $category,
                "topics" => $topics
            ]
        ];
    }

    public function openTopicByID($id) {
        $topicManager=new TopicManager();
        $topic=$topicManager->findOneById($id);
        $categoryManager=new CategoryManager();
        $category=$categoryManager->findOneById($topic->getCategoryId());
        $postManager=new PostManager();
        $posts= $postManager->findPostsByTopicId($id);
        $postTexts=[];
        foreach ($posts as $post){
            $postTexts[]=$post->getText();
        }
        return [
            "view" => VIEW_DIR."forum/topicById.php",
            "meta_description" => "Détail d'un topic",
            "data" => [
                "topic" => $topic,
                "category" => $category,
                "title" => $topic->getTitle(),
                "postTexts" => $postTexts
            ]
        ];
    }
    public function backHomePage(){
        return [
            "view" => VIEW_DIR."home.php",
            "meta_description" => "Page d'accueil du forum"
        ];
    }
}