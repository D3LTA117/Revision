<?php

namespace Controllers;

class FormController {
    public function getFormTraining(int $id, int $status) {
        $model = new \Models\Cards();
        $cards = $model->modifyCards($id, $status);
        
        header('Location: index.php?route=training&id=' . $_SESSION['package']);
        exit;
    }
}