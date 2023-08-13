<?php

namespace Controllers;

class TrainingController {
    
    public function getNeedCardsToTraining(array $cards) {
        /* 
        0 = jamais vu
        1 = 10 min
        2 = 1 j
        3 = 2 j
        4 = 4 j
        5 = 1 semaine
        6 = 1 mois
        */

        $filtredCards = [];
        date_default_timezone_set('Europe/Paris');
        $dateActuelle = date_create('now')->format('Y-m-d H:i:s');
        $timestamp = strtotime($dateActuelle);

        foreach ($cards as $card) {

            $time = strtotime($card['date']);
            $card['date'] = $time;

            switch ($card['status']) {
                case '1':
                    $card['date'] += 600;
                break;

                case '2':
                    $card['date'] += 86400;
                break;

                case '3':
                    $card['date'] += 172800;
                break;

                case '4':
                    $card['date'] += 345600;
                break;

                case '5':
                    $card['date'] += 604800;
                break;

                case '6':
                    $card['date'] += 2678400;
                break;
            }

            if ($card['date'] < $timestamp) {
                $filtredCards[] = $card;
            }
        }
        return $filtredCards;
    }
}