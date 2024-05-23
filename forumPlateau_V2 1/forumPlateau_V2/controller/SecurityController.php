<?php

namespace Controller;

use App\AbstractController;
use App\Session;
use Model\Managers\UserManager;
use Model\Managers\TopicManager;

class SecurityController extends AbstractController {
    // Méthodes liées à l'authentification : register, login et logout

    public function register() {
        return [
            "view" => VIEW_DIR . "security/register.php",
            "meta_description" => "Registration Form"
        ];
    }

    public function addRegistration() {
        if (isset($_POST["submit"])) {
            $userManager = new UserManager();

            // Nettoyage et validation des données
            $nickName = ucfirst(filter_input(INPUT_POST, "nickName", FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $mdp1 = filter_input(INPUT_POST, "mdp", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $mdp2 = filter_input(INPUT_POST, "mdpdVerif", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
            $image=$_FILES['image']['name'];
            $fileTmp=$_FILES['image']['tmp_name'];
            $uploadeDirection = "public/images/photoDeProfil";
            
            
            $defaultImage='public/defaultPics/images.png';
            
            if ($image){
                $extension = pathinfo($image, PATHINFO_EXTENSION);
                $newName = uniqid().".".$extension;
                $uploadFile = $uploadeDirection."/".$newName;
                $finalPath = $uploadeDirection.$newName;
                move_uploaded_file($fileTmp, $uploadFile);
            }elseif(empty($image)){
                $finalPath=$defaultImage;
            }else{
                $finalPath=$defaultImage;
            }

            // Vérification de l'unicité du NickName et de l'email
            $nickNameExists = $userManager->findUserByNickName($nickName);
            $emailExists = $userManager->findUserByEmail($email);

            if ($nickNameExists) {
                Session::addFlash("message", "Le NickName est déjà utilisé.");
                $this->redirectTo("security", "register");
            }

            if ($emailExists) {
                Session::addFlash("message", "L'email est déjà utilisé.");
                $this->redirectTo("security", "register");
            }

            // Vérification du mot de passe
            $regexMdp = preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/', $mdp1);

            if ($mdp1 !== $mdp2 || !$regexMdp) {
                Session::addFlash("message", "Le mot de passe n'est pas correct. Assurez-vous qu'il contient au moins une majuscule, une minuscule, un chiffre et un caractère spécial.");
                $this->redirectTo("security", "register");
            }
            $hashedPassword = password_hash($mdp1, PASSWORD_DEFAULT);

            // Si tout est correct, insérer l'utilisateur dans la base de données
            $userManager->add([
                "nickName" => $nickName,
                "mdp" => $hashedPassword,
                "email" => $email,
                "image" => $finalPath
            ]);
            Session::addFlash("message", "Vous êtes bien inscrit!");
            Session::setUser($userManager->findUserByEmail($email));
            $this->redirectTo("security", "profile");
        }
    }

    public function login() {
        
        return[
            "view" => VIEW_DIR. "security/login.php",
            "meta_description" => "Login Form"
        ];
    }

    public function loginUser(){
        if(isset($_POST["submit"])){
            $userManager = new UserManager();
            $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
            $mdp = filter_input(INPUT_POST, "mdp", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            
            if($email && $mdp){
                $user=$userManager->findUserByEmail($email);
                // var_dump($user);die;
                if($user){
                  $hash=$user->getMdp();
                    if(password_verify($mdp, $hash)){
                        Session::addFlash("message", "Vous êtes bien connecté!");
                        Session::setUser($user);
                        $this->redirectTo("forum", "backHomePage");
                    }else{
                        Session::addFlash("message", "Mot de passe incorrect");
                        $this->redirectTo("security", "login");
                    }
                
                }else{
                    Session::addFlash("message", "Email incorrect");
                    $this->redirectTo("security", "login");
                    }
                }
            }
        }
        public static function logout(){
            Session::destroy();
            Session::addFlash("success", "Vous êtes déconnecté");
            return [
                "view" => VIEW_DIR. "home.php",
                "meta_description" => "Login Form"
            ];
        }

        public static function profile(){
            $topicManager = new TopicManager();
            $topics=$topicManager->findTopicsByUser(Session::getUser()->getid());
            return [
                "view" => VIEW_DIR. "security/profil.php",
                "meta_description" => "Login Form",
                "data"=>[
                    "user"=>Session::getUser(),
                    "topics"=>$topics
                ]
            ];
        }

        public function editProfile(){
            if(isset($_POST["submit"])){
                
                $user = Session::getUser()->getid();
                $userManager = new UserManager();
                $nickName=filter_input(INPUT_POST, "nickName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $email=filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
                $mdp=filter_input(INPUT_POST, "mdp", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $mdp2=filter_input(INPUT_POST, "mdp2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $image=$_FILES["image"]["name"];
                $regexMdp = preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/', $mdp);
                $uploadeDirection = "public/images/photoDeProfil/";
                $fileTmp = $_FILES["image"]["tmp_name"];

                

                if($nickName){
                    var_dump($user,$nickName);
                    $userManager->updateUserNickName([
                        "nickName" => $nickName,
                        "id" => $user]);

                        Session::addFlash("message", "Votre nom d'utilisateur a bien été modifié");
                    }elseif($email){
                        $userManager->updateUserEmail([
                            "email" => $email,
                            "id" => $user]);
                        
                            Session::addFlash("message", "Votre email a bien été modifié");
                    }elseif($mdp && $mdp2){
                        if ($mdp !== $mdp2 || !$regexMdp) {
                            Session::addFlash("message", "Les mots de passe sont pas identiques, ou les critres d mot de passe ne sont pas respectés.. Assurez-vous qu'il contient au moins une majuscule, une minuscule, un chiffre et un caractère spécial.");
                            $this->redirectTo("security", "profile");
                        }
                        $hashedPassword = password_hash($mdp, PASSWORD_DEFAULT);
                        $userManager->updateUserMdp([
                            "mdp" => $hashedPassword,
                            "id" => $user]);
                            var_dump($user,$hashedPassword);die;
                            Session::addFlash("message", "Votre mot de passe a bien été modifié");
                    }elseif($image){
                        $extension = pathinfo($image, PATHINFO_EXTENSION);
                        $newName = uniqid().".".$extension;
                        $uploadFile = $uploadeDirection."/".$newName;
                        $finalPath = $uploadeDirection.$newName;
                        move_uploaded_file($fileTmp, $uploadFile);

                        $data=[
                            "image" => $finalPath,
                            "id" => $user
                        ];
                        $userManager->updateUserImage([
                            "image" =>$data["image"],
                            "id" => $data["id"]]);
                            Session::addFlash("message", "Votre photo de profil a bien été modifié");

                    $this->redirectTo("security", "profile");
                }
            }
        }
    }