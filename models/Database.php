<?php

namespace Models;

require('config/config.php');

class Database {

    protected $bdd;

    public function __construct(){
        try {
            $this->bdd = new \PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS, [
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ]);
        } catch (\PDOException $e) {error_log(date('Y-m-d H:i:s') . " Erreur: " . $e->getMessage() . PHP_EOL, 3, "errors.log");}
    }

    protected function findAll(string $req, array $params = []) :array {
        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetchAll();
    }

    protected function findOne(string $req, array $params = []) {
        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetch();
    }

    protected function addOne(string $table, string $columns, string $values, $data ) {
        $query = $this->bdd->prepare('INSERT INTO ' . $table . '(' . $columns . ') values (' . $values . ')');
        $query->execute($data);
        $query->closeCursor();
    }

    protected function deleteOneById(string $table, array $params) {
        $query = $this->bdd->prepare("DELETE FROM " . $table . " WHERE id = :id");
        $query->execute($params);
        $query->closeCursor();
    }

    protected function updateOne(string $req, array $params = []) {
        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetch();
    }
}