<?php
    require_once "./vendor/autoload.php";

    use \PhpOffice\PhpSpreadsheet\Reader\Xlsx;

    require_once "./helpers/CustomExcellReaderFilter.php";
    require_once "./DataInsertionController.php";
    require_once "./db/DB.php";

    if(isset($_GET['insertion'])){
        /** INSERTIO NDES DONNEES */
        $inputFileName = 'bd.xlsx';
        $reader = new Xlsx();
        //$filterSubset = new CustomExcellReaderFilter();

        $dataInsertionObject = new DataInsertionController($inputFileName, $reader);
        $dataInsertionObject->extractDatas();
    }
    else{
        var_dump(parse_url(getenv('DATABASE_URL')));
        var_dump(DB::getInstance());
        echo ('<h1>HELLO THiiiiiiOOOoo</h1>');
    }
?>