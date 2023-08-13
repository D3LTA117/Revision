<?php

namespace Controllers;

class TokenController {
    public function genererChaineAleatoire($longueur = 128) {
        $token = substr(str_shuffle(str_repeat($code='0123456789ABCDEFGHJKLMNPQRSTVWXYZacefhjkmnrstvwxyz', ceil($longueur/strlen($code)) )),1,$longueur);
        return $token;
    }
}