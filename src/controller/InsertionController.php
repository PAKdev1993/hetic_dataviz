<?php

namespace src\Controller;

class InsertionController 
{
    const PATH_DATA = './data/bd.xlsx';

    private $excellReader;
    private $inputFileName;

    /**
     * INSERTION DES DONNEES
     */
    public function index(InsertionInterface $insertor) {
        $response = $insertor->insertData();

        if( !$response ) {
            throw new Exception("L'insertion a échoué"); 
        }
        return $response;
    }
}