<?php

namespace Controller;

use App\AbstractController;
use App\Session;
use Model\Managers\UserManager;

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

            // Vérification du NickName
            $regexUser = preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).+$/', $nickName);

            if (!$regexUser) {
                Session::addFlash("message", "Le NickName n'est pas correct. Assurez-vous qu'il contient au moins une majuscule, une minuscule et un chiffre.");
                $this->redirectTo("security", "register");
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
                "email" => $email
            ]);
            Session::addFlash("message", "Vous êtes bien inscrit!");
            $this->redirectTo("security", "register");
        }
    }

    public function login() {
        
    }

    public function logout() {
        
    }
}
