<?php

namespace Models;

class Customers extends Database {

    public function getOneCustomer(string $email) {
        $req = "SELECT id, email, password, role_id FROM users WHERE email = ?";
        return $this->findOne($req, [$email]);
    }

    public function addNewUser($data) {
        $this->addOne('users',
            'email, password, role_id',
            '?,?,?', $data);
    }
}