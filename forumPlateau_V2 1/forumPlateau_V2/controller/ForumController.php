<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;
use Model\Managers\UserManager;

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
        $postManager=new PostManager();
        $topic=$topicManager->findOneById($id);
        $posts=$postManager->findPostsByTopicId($id);
        $category=$topic->getCategory();
       
        return [
            "view" => VIEW_DIR."forum/topicById.php",
            "meta_description" => "Détail d'un topic",
            "data" => [
                "topic" => $topic,
                "category" => $category,
                "posts" => $posts,
            ]
        ];
    }

    
    public function backHomePage(){
        
        return [
            "view" => VIEW_DIR."home.php",
            "meta_description" => "Page d'accueil du forum"
        ];
    }

    public function toAdminPage(){
        $categoryManager = new CategoryManager();
        $userManager = new UserManager();
        $categories = $categoryManager->findAll(["name", "DESC"]);
        $users = $userManager->findAll(["nickName", "DESC"]);
        return [
            "view" => VIEW_DIR."adminPage.php",
            "meta_description" => "Page d'administration du forum",
            "data" => [
                "categories" => $categories,
                "users" => $users
            ]
        ];
    }

    public function addCategory() {

        $categoryManager = new CategoryManager();
        if(isset($_POST["submit"])) {

            $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if($name) {
                $categoryManager->add([
                    "name" => $name
                ]);

                $this->redirectTo("forum", "index");
            }
        }
    }

    public function sendMessage($id){
        $postManager = new PostManager();
        $topicManager = new TopicManager();
        $userManager = new UserManager();
        $userId=Session::getUser()->getId();

        // var_dump($userId);die;

        if(isset($_POST["submit"])){
            $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          
            if($text){
                $postManager->add([
                    "text" => $text,
                    "topic_id" => $id,
                    "user_id" => $userId
                ]);
                $this->redirectTo("forum", "openTopicByID", $id);
            }
        }
    }

    public function addTopicAndFirstMessage($id) {
        $topicManager = new TopicManager();
        $postManager = new PostManager();
        $categoryManager = new CategoryManager();
        $userManager = new UserManager();
        $user = $userManager->findOneById($id);
        $category = $categoryManager->findOneById($id);
    
        if (isset($_POST["submit"])) {
            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $categoryId = filter_input(INPUT_POST, "category_id", FILTER_VALIDATE_INT);
            $userId = filter_input(INPUT_POST, "user_id", FILTER_VALIDATE_INT);
            
            if ($title && $text && $categoryId && $userId) {
                // Ajouter le nouveau sujet et récupérer son identifiant
                $topicId = $topicManager->add([
                    "title" => $title,
                    "category_id" => $categoryId,
                    "user_id" => $userId
                ]);
                
                // Assurez-vous que l'ajout du sujet a réussi et que l'identifiant a été récupéré
                if ($topicId) {
                    // Ajouter le premier message associé à ce sujet
                    $postManager->add([
                        "text" => $text,
                        "topic_id" => $topicId,
                        "user_id" => $userId
                    ]);
                    
                    // Rediriger vers le sujet nouvellement créé
                    $this->redirectTo("forum", "openTopicByID", $topicId);
                } else {
                    // Gestion des erreurs si la création du sujet a échoué
                    echo "Erreur lors de la création du sujet.";
                }
            }
        }
    }

    public function toAddTopic(){
        $categoryManager = new CategoryManager();
        
        return[
            "view" => VIEW_DIR."forum/addTopic.php",
            "meta_description" => "Ajouter un topic",
            "data"=>[
                "categories" => $categoryManager->findAll()
            ]
            
        ];
    }

    public function addTopicAndPostByUser() {


        $topicManager = new TopicManager();
        $postManager = new PostManager();
        $categoryManager = new CategoryManager();
        $userManager = new UserManager();
        $userId = Session::getUser()->getId();
        $user = $userManager->findOneById($userId)->getId();
        
       
        if (isset($_POST["submit"])) 
            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $categoryId = filter_input(INPUT_POST, "category_id", FILTER_VALIDATE_INT);
            $userId = filter_input(INPUT_POST, "user_id", FILTER_VALIDATE_INT);
            var_dump($title, $text, $categoryId, $userId);
            if ($title && $text && $categoryId && $user) {
                // Ajouter le nouveau sujet et récupérer son identifiant
                $topicId = $topicManager->add([
                    "title" => $title,
                    "category_id" => $categoryId,
                    "user_id" => $user
                ]);
                if ($topicId) {
                    // Ajouter le premier message associé à ce sujet
                    $postManager->add([
                        "text" => $text,
                        "topic_id" => $topicId,
                        "user_id" => $user
                    ]);
                    // Rediriger vers le sujet nouvellement créé
                    $this->redirectTo("forum", "openTopicByID", $topicId);
                }else {
                    // Gestion des erreurs si la création du sujet a échoué
                    echo "Erreur lors de la création du sujet.";
                }
            }
        }
    }