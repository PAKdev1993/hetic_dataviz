<?php
require_once 'app/Autoloader.php';

use app\Autoloader;
use app\DB;

//API
parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $get_array);

if( isset($get_array['action']) ){

    Autoloader::register();

    $db = DB::getInstance();

    header('Content-type: application/json; charset=utf-8');

    switch($get_array['action']){
        //recuperation des données formatée dans un obj json
        case "all" :
            echo json_encode($db->getAll());
            break;
        case "introduction" :
            echo json_encode($db->getIntro());
            break;
        case "conclusion" :
            echo json_encode($db->getConclusion());
            break;
        case "body" :
            echo json_encode($db->getBody());
            break;
        case "vocabulaire" :
            echo json_encode($db->getVocabulaire());
            break;
        default :
            echo json_encode(array('error' => 'commande inconnue'));
            break;
    }
}
else{
    return json_encode([]);
}