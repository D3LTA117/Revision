<?php

session_start();

spl_autoload_register(function($class) {
    require_once lcfirst(str_replace('\\','/', $class)) . '.php';
});

if(array_key_exists("route", $_GET)):
    switch($_GET['route']) {
        case 'home':
            $controller = new Controllers\DisplayController;
            $controller->displayAllPackages();
        break;

        // AFFICHAGE DE LA SESSION DE REVISION
        case 'training':
            $controller = new Controllers\DisplayController;
            $controller->displayAllCards(intval($_GET['id']), $_SESSION['user']['id']);
        break;
        
        // AFFICHAGE DE L'AJOUT D'UNE CARTE
        case 'addCards':
            $controller = new Controllers\DisplayController;
            $controller->displayAddCards();
        break;
        
        // AFFICHAGE DE LA MODIFICATION D'UN PAQUET
        case 'packagesToModify':
            $controller = new Controllers\DisplayController;
            $controller->displayAllPackages();
        break;
        
        // AFFICHAGE DU TOTAL DE CARTES DANS UN PAQUET
        case 'allCards':
            $controller = new Controllers\DisplayController;
            $controller->displayAllCards(intval($_GET['id']), $_SESSION['user']['id']);
        break;

        // AFFICHAGE DU FORMULAIRE DE CREATION DE COMPTE
        case 'addUsers':
            $controller = new Controllers\DisplayController;
            $controller->displayFormAddUsers();
        break;
        
        // SOUMISSION DU FORMULAIRE POUR AJOUTER UNE CARTE
        case 'submitNewCards':
            $controller = new Controllers\CardsController;
            $controller->addCards();
        break;

        // SOUMISSION DU FORMULAIRE DE CREATION DE COMPTE
        case 'submitFormAddUser':
            $controller = new Controllers\CustomersController;
            $controller->submitFormAddUser();
        break;

        // SOUMISSION DU FORMULAIRE DE CREATION DE PAQUET
        case 'submitFormAddPackage':
            $controller = new Controllers\CustomersController;
            $controller->submitFormAddPackage();
        break;

        // SOUMISSION DE LA MODIFICATION D'UNE CARTE
        case 'submitFormTraining':
            $controller = new Controllers\FormController;
            $controller->getFormTraining(intval($_GET['id']), intval($_GET['level']));
        break;

        // SOUMISSION DE LA SUPPRESSION D'UNE CARTE
        case 'deleteCard':
            $controller = new Controllers\CardsController;
            $controller->deleteCard(intval($_GET['id']), $_SESSION['user']['id']);
        break;

        case 'connection':
            $controller = new Controllers\CustomersController;
            $controller->connection();
        break;

        case 'disconnect':
            $controller = new Controllers\CustomersController;
            $controller->disconnection();
        break;

        default:
            header('location: index.php?route=home');
            exit;
        break;
    }
else:
    header('Location: index.php?route=home');
    exit;
endif;