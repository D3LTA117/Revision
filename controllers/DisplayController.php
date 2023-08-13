<?php

namespace Controllers;

class DisplayController {

    public function displayAllPackages() {
        if (isset($_SESSION['user'])) {
            $model = new \Models\Packages();
            $packages = $model->getAllPackages();
            
            switch ($_GET['route']) {
                case 'packagesToModify':
                    $model = new TokenController();
                    $addPackageToken = $model->genererChaineAleatoire();
                    $_SESSION['addNewPackageToken'] = $addPackageToken;
                    $title = "Créer/modifier un paquet de cartes";
                    $template = "packagesToModify.phtml";
                    include_once 'views/layout.phtml';
                break;
                
                default:
                    $template = "home.phtml";
                    include_once 'views/layout.phtml';
                break;
            }
        } else {
            $template = "home.phtml";
            include_once 'views/layout.phtml';
        }
    }
    
    public function displayAllCards(int $id, int $user_id) {
        $model = new \Models\Cards();
        $cards = $model->getAllCards($id, $user_id);
        
        $model = new \Models\Packages();
        $package = $model->getOnePackageId($id, $user_id);
        $_SESSION['package'] = $package['id'];

        if(!empty($cards)) {
            switch ($_GET['route']) {
                case 'allCards':
                    $title = "Affichage du nombre total de carte dans le paquet";
                    $template = "allCards.phtml";
                    include_once 'views/layout.phtml';
                break;
                
                case 'training':
                    $model = new TrainingController();
                    $filtredCards = $model->getNeedCardsToTraining($cards);
                    $title = "Session de révision";
                    $template = "training.phtml";
                    include_once 'views/layout.phtml';
                break;
                
                default:
                    $template = "home.phtml";
                    include_once 'views/layout.phtml';
                break;
            }
        } else {
            $errors[] = 'Le paquet est vide';
            $_SESSION['errors'] = $errors[0];
            $template = "home.phtml";
            include_once 'views/layout.phtml';
            exit;
        }
    }
    
    public function displayFormAddUsers() {
        if (!isset($_SESSION['user'])) {
            $model = new TokenController();
            $logToken = $model->genererChaineAleatoire();
            $_SESSION['log'] = $logToken;
            
            $newToken = $model->genererChaineAleatoire();
            $_SESSION['new'] = $newToken;
            
            $title = "Connexion";
            $template = "formAddUser.phtml";
            include_once 'views/layout.phtml';
        } else {
            $template = "home.phtml";
            include_once 'views/layout.phtml';
        }
    }
    
    public function displayAddCards() {
        if (isset($_SESSION['user'])) {
            $model = new TokenController();
            $addCardsToken = $model->genererChaineAleatoire();
            $_SESSION['addCardsToken'] = $addCardsToken;
            
            $model = new \Models\Packages();
            $packages = $model->getAllPackages();
            
            $title = "Ajouter/modifier une carte";
            $template = "addCards.phtml";
            include_once 'views/layout.phtml';
        } else {
            $template = "home.phtml";
            include_once 'views/layout.phtml';
        }
    }
}