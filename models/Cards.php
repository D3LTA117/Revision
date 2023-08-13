<?php

namespace Models;

class Cards extends Database {
    public function addCards($data) {
        $this->addOne('cards',
            'recto, verso, packages_id',
            '?,?,?', $data);
    }
    
    public function getOneCardRecto(string $recto, int $user_id) {
        $req = "SELECT recto FROM cards
        INNER JOIN packages ON cards.packages_id = packages.id
        INNER JOIN users ON packages.users_id = users.id
        WHERE recto = :recto AND users_id = :user_id";
        $params = [
            "recto"=>$recto,
            "user_id"=>$user_id
        ];
        return $this->findOne($req, $params);
    }
    
    public function getOneCardVerso(string $verso, int $user_id) {
        $req = "SELECT verso FROM cards
        INNER JOIN packages ON cards.packages_id = packages.id
        INNER JOIN users ON packages.users_id = users.id
        WHERE verso = :verso AND users_id = :user_id";
        $params = [
            "verso"=>$verso,
            "user_id"=>$user_id
        ];
        return $this->findOne($req, $params);
    }

    public function getOneCardId(int $id, int $user_id) {
        $req = "SELECT cards.id FROM cards
        INNER JOIN packages ON cards.packages_id = packages.id
        INNER JOIN users ON packages.users_id = users.id
        WHERE cards.id = :id AND users_id = :user_id";
        $params = [
            "id"=>$id,
            "user_id"=>$user_id
        ];
        return $this->findOne($req, $params);
    }
    
    public function getAllCards(int $id, int $user_id) {
        $req = "SELECT cards.id, recto, verso, status, date FROM cards
        INNER JOIN packages ON cards.packages_id = packages.id
        INNER JOIN users ON packages.users_id = users.id
        WHERE packages_id = :id AND users_id = :user_id";
        $params = [
            "id"=>$id,
            "user_id"=>$user_id
        ];
        return $this->findAll($req, $params);
    }
    
    public function modifyCards(int $id, int $status) {
        $req = "UPDATE cards SET status = :status, date = NOW() WHERE id = :id";
        $params = [
            "id"=>$id,
            "status"=>$status
        ];
        return $this->updateOne($req, $params);
    }
    
    public function deleteCards(int $id) {
        $params = [
            "id"=>$id
        ];
        return $this->deleteOneById("cards", $params);
    }
}