<?php

namespace Controllers;

class CustomersController {
    public function submitFormAddUser() {
        $errors = [];
        $valids = [];

        if(array_key_exists('newEmail', $_POST) &&
            array_key_exists('newPassword', $_POST) &&
            array_key_exists('password_confirme', $_POST) &&
            array_key_exists('newToken', $_POST)) {
                
                if ($_POST['newToken'] !== $_SESSION['new']) {
                    $errors[] = 'Jeton invalide';
                    $_SESSION['errors'] = $errors[0];
                    header('Location: index.php?route=addUsers');
                    exit;
                }

                $fraude = strpos($_POST['newEmail'], '+');
                if(!filter_var($_POST['newEmail'], FILTER_VALIDATE_EMAIL) || !empty($fraude)) {
                    $errors[] =  'Veuillez renseigner un email valide SVP !';
                    $_SESSION['errors'] = $errors[0];
                    header('Location: index.php?route=addUsers');
                    exit;
                }

                if(strlen($_POST['newPassword']) < 8) {
                    $errors[] = "→ Votre mot de passe doit contenir au minimum 8 caractères !";
                    $_SESSION['errors'] = $errors[0];
                    header('Location: index.php?route=addUsers');
                    exit;
                }

                if($_POST['newPassword'] != $_POST['password_confirme']) {
                    $errors[] = "Vous n'avez pas confirmé correctement votre mot de passe !";
                    $_SESSION['errors'] = $errors[0];
                    header('Location: index.php?route=addUsers');
                    exit;
                }

                if(count($errors) == 0) {
                    $model = new \Models\Customers();
                    $custormerExist = $model->getOneCustomer($_POST['newEmail']);

                    if(!empty($custormerExist)) {
                        $errors[] = 'Cette adresse e-mail existe déjà !';
                        $_SESSION['errors'] = $errors[0];
                        header('Location: index.php?route=addUsers');
                        exit;
                    }


                    if(count($errors) == 0) {

                        $password = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);

                        $data = [
                            trim(strtolower($_POST['newEmail'])),
                            trim($password),
                            2
                        ];

                        $model = new \Models\Customers();
                        $resultUser_mail = $model->addNewUser($data);
                        $valids[] = 'Votre demande de création de compte a bien été enregistrée, veuillez vous connecter.';
                        $_SESSION['valids'] = $valids[0];
                    }
                }
        }

        $model = new DisplayController;
        $model->displayFormAddUsers();
    }

    public function submitFormAddPackage() {
        $errors = [];
        $valids = [];

        if(array_key_exists('nameFormPackage', $_POST) &&
        array_key_exists('addPackageToken', $_POST)) {
            if(empty($_POST['nameFormPackage']) ||
            empty($_POST['addPackageToken'])) {
                    $errors[] = 'Veuillez remplir tous les champs';
                    $_SESSION['errors'] = $errors[0];
                    header('Location: index.php?route=packagesToModify');
                    exit;
                } else {
                if ($_POST['addPackageToken'] !== $_SESSION['addNewPackageToken']) {
                    $errors[] = 'Jeton invalide';
                    $_SESSION['errors'] = $errors[0];
                    header('Location: index.php?route=home');
                    exit;
                } else {
                    $name = $_POST['nameFormPackage'];
                    $user_id = $_SESSION['user']['id'];
                    $model = new \Models\Packages();
                    $package = $model->getOnePackageName($name, $user_id);
                    
                    if(!empty($package)) {
                        $errors[] = 'Paquet déjà existant';
                        $_SESSION['errors'] = $errors[0];
                        header('Location: index.php?route=packagesToModify');
                        exit;
                    } else {
                        $data = [
                            $_POST['nameFormPackage'],
                            $_SESSION['user']['id']
                        ];

                        $package = $model->addPackage($data);
                        $valids[] = 'Le paquet a été enregistré';
                        $_SESSION['valids'] = $valids[0];
                        header('Location: index.php?route=home');
                        exit;
                    }
                }
            }
        }
    }

    public function connection() {
        
        $errors = [];
        if (array_key_exists('email', $_POST) && array_key_exists('password', $_POST) && array_key_exists('logToken', $_POST)) {
            
            if ($_POST['logToken'] !== $_SESSION['log']) {
                $errors[] = 'Jeton invalide';
                $_SESSION['errors'] = $errors[0];
                header('Location: index.php?route=addUsers');
                exit;
            }
            
            $fraude = strpos($_POST['email'], '+');
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || !empty($fraude)) {
                $errors[] = 'Veuillez renseigner une adresse mail valide';
                $_SESSION['errors'] = $errors[0];
                header('Location: index.php?route=addUsers');
                exit;
            }

            if(strlen($_POST['password']) < 8) {
                $errors[] = 'Veuillez renseigner un mdp valide';
                $_SESSION['errors'] = $errors[0];
                header('Location: index.php?route=addUsers');
                exit;
            }

            if (count($errors) == 0) {
                $model = new \Models\Customers();
                $userExist = $model->getOneCustomer($_POST['email']);
                if ($userExist !== false) {
                    if (password_verify($_POST['password'], $userExist['password'])) {
                        $_SESSION['user'] = [
                            'id' => $userExist['id'],
                            'email' => $userExist['email'],
                            'role' => $userExist['role_id']
                        ];
                        $valids[] = 'Vous êtes connecté.';
                        $_SESSION['valids'] = $valids[0];
                        header('Location: index.php?route=home');
                        exit;
                    } else {
                        $errors[] = 'L\'adresse mail ou le mdp ne sont pas corrects';
                        $_SESSION['errors'] = $errors[0];
                        header('Location: index.php?route=addUsers');
                        exit;
                    }
                } else {
                    $errors[] = "Erreur d'identification";
                    $_SESSION['errors'] = $errors[0];
                    header('Location: index.php?route=addUsers');
                    exit;
                }
            } else {
                $errors[] = "Un problème est survenue";
                $_SESSION['errors'] = $errors[0];
                header('Location: index.php?route=addUsers');
                exit;
            }
        } else {
            $errors[] = 'Un problème est survenue';
            $_SESSION['errors'] = $errors[0];
            header('Location: index.php?route=addUsers');
            exit;
        }
    }

    public function disconnection() {
        session_destroy();
        header('Location: index.php?route=home');
        exit;
    }
}