<?php

namespace Controllers;

class CardsController {
    
    public function addCards() {
        $errors = [];
        $valids = [];
        if (array_key_exists('recto', $_POST) &&
        array_key_exists('verso', $_POST) &&
        array_key_exists('packages_id', $_POST) &&
        array_key_exists('addCardsToken', $_POST)) {
            
            if (empty($_POST['recto']) ||
            empty($_POST['verso']) ||
            empty($_POST['packages_id'])) {
                $errors[] = 'Veuillez remplir tous les champs';
                $_SESSION['errors'] = $errors[0];
                header('Location: index.php?route=addCards');
                exit;
            }
            
            if ($_POST['addCardsToken'] !== $_SESSION['addCardsToken']) {
                $errors[] = 'Jeton invalide';
                $_SESSION['errors'] = $errors[0];
                header('Location: index.php?route=addCards');
                exit;
            }
            
            if(count($errors) == 0) {
                $model = new \Models\Cards();
                $cardRectoExist = $model->getOneCardRecto($_POST['recto'], $_SESSION['user']['id']);
                $cardVersoExist = $model->getOneCardVerso($_POST['verso'], $_SESSION['user']['id']);
                
                $model = new \Models\Packages();
                $packageExist = $model->getOnePackageId($_POST['packages_id'], $_SESSION['user']['id']);

                if(empty($packageExist)) {
                    $errors[] =  'Le paquet n\'existe pas dans la base de données';
                    $_SESSION['errors'] = $errors[0];
                    header('Location: index.php?route=addCards');
                    exit;
                }

                if($cardRectoExist && $cardVersoExist) {
                    $errors[] = 'Carte déjà existante dans la base de données';
                    $_SESSION['errors'] = $errors[0];
                    header('Location: index.php?route=addCards');
                    exit;
                }

                if(count($errors) == 0) {
                    $data = [
                        $_POST['recto'],
                        $_POST['verso'],
                        $_POST['packages_id']
                    ];

                    $model = new \Models\Cards();
                    $resultAddCards = $model->addCards($data);
                    $valids[] = 'La carte a été enregistré';
                    $_SESSION['valids'] = $valids[0];
                    header('Location: index.php?route=addCards');
                    exit;
                }
            }
        } else {
            $errors[] = 'Une erreur est survenue';
            $_SESSION['errors'] = $errors[0];
            header('Location: index.php?route=addCards');
            exit;
        }
        
        $model = new Controllers\DisplayController;
        $model->displayAddCards();
    }

    public function deleteCard(int $id, int $user_id) {
        $model = new \Models\Cards();
        $verif = $model->getOneCardId($id, $user_id);
        if(!empty($verif)) {
            $model->deleteCards($id);
            $valids[] = 'La carte a été supprimé';
            $_SESSION['valids'] = $valids[0];
        } else {
            $errors[] = 'Une erreur est survenue';
            $_SESSION['errors'] = $errors[0];
        }
        header('Location: index.php?route=home');
        exit;
    }
}