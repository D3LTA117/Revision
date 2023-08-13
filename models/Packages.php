<?php

namespace Models;

class Packages extends Database {
    public function getAllPackages() {
        $req = "SELECT name, id FROM packages WHERE users_id = :id";
        $params = [
            "id"=>$_SESSION['user']['id']
        ];
        return $this->findAll($req, $params);
    }
    
    public function addPackage($data) {
        $this->addOne('packages',
            'name, users_id',
            '?,?', $data);
    }
    
    public function getOnePackageName(string $name, int $user_id) {
        $req = "SELECT packages.name, users_id FROM packages
        INNER JOIN users ON packages.users_id = users.id
        WHERE packages.name = :name AND users_id = :user_id";
        $params = [
            "name"=>$name,
            "user_id"=>$user_id
        ];
        return $this->findOne($req, $params);
    }
    
    public function getOnePackageId(int $id, int $user_id) {
        $req = "SELECT packages.id, name, users_id FROM packages
        INNER JOIN users ON packages.users_id = users.id
        WHERE packages.id = :id AND users_id = :user_id";
        $params = [
            "id"=>$id,
            "user_id"=>$user_id
        ];
        return $this->findOne($req, $params);
    }
}