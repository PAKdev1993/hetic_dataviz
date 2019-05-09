<?php      

    require "Eleve.php";
    require "EleveDB.php";
    require "Cleaner.php";

    use \PhpOffice\PhpSpreadsheet\Calculation\Functions;

    class DataInsertionController{

        private $spreadsheet;

        const PATH_FOLDER_DATA = './data/';

        public function __construct($inputFileName, $excellReader, $customExcellReader = null)
        {
            $this->mappingFile = $this->fetchMappingFile();            
            $this->initSpeadsheetReader($inputFileName, $excellReader, $customExcellReader);
        }

        public function initSpeadsheetReader($inputFileName, $excellReader, $customExcellReader = null)
        {
            $pathToFile = self::PATH_FOLDER_DATA . $inputFileName;

            $excellReader->setReadDataOnly(true); // Tell the Reader that we want to Read Only
            if ($customExcellReader) $excellReader->setReadFilter($customExcellReader);// Tell the Reader that we want to use the Read Filter
            $this->spreadsheet = $excellReader->load($pathToFile); // Load only the rows and columns that match our filter to Spreadsheet
        }

        public function fetchMappingFile()
        {
            // Read JSON file
            $json = file_get_contents(self::PATH_FOLDER_DATA . 'bd_mapping.json');
            return json_decode($json);
        }
        
        public function extractDatas()
        {
            $eleveDB = new EleveDB();
            $itfCleaner = new Cleaner();
            //parcours des sheets
            foreach($this->mappingFile->sheetMarkpoints as $sheetMapping)
            {
                //init var pour les parcours
                $currentSheet = $this->spreadsheet->getSheetByName($sheetMapping->title);
                $maxLine = $sheetMapping->beginLine + $sheetMapping->nbLines;

                //parcours des lignes de la sheet
                for($line = $sheetMapping->beginLine; $line <= $maxLine; $line++)
                {
                    //instanciation de l'objet eleve a inserer
                    $eleveObject = new Eleve($itfCleaner);

                    //parcours des infos de mapping
                    foreach($sheetMapping as $key => $values)
                    {
                        if($key === "props" || $key ===  "props_periode_6_mois" || $key === "props_periode_actuelle")
                        {
                            //parcours du mapping des propriétés (celles préfixées par props) a inserer ds l'objet eleve
                            foreach($values as $prop => $col)
                            {
                                $content = null;
                                
                                switch($key){
                                    case "props" : {
                                        //traitement particuliers
                                        if($prop === "promo" || $prop === "annee_promo")
                                        {
                                            $content = $col; //pour ces cas particuliers $col contient la valeur a ecrire et non un identifiant de colonne
                                        }

                                        //traitement normal
                                        else{
                                            if($col !== null)
                                            {
                                                $cellToRead = (string) $col . $line;
                                                $content = $currentSheet->getCell($cellToRead, false)->getValue();
                                            }
                                            //cas ou col est null
                                            else{
                                                $content = null;
                                            }
                                        }

                                        //peupler etudiant
                                        $eleveObject->{$prop} = $content;
                                        break;
                                    }
                                    case "props_periode_6_mois" || "props_periode_actuelle" : {
                                        if($col !== null)
                                        {
                                            $cellToRead = (string) $col . $line;
                                            $content = $currentSheet->getCell($cellToRead, false)->getValue();
                                        }
                                        //cas ou col est null
                                        else{
                                            $content = null;
                                        }

                                        //peupler etudiant
                                        $eleveObject->{$key . "__" . $prop} = $content; //on prefixe avec la clef pour ne pas ecraser les valeurs
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    //clean l'eleve pour l'insertion
                    $eleveObject->cleanProperties();

                    //insertion de la ligne en BD
                    $eleveDB->insert($eleveObject);
                }
                //passage a la ligne suivante
            }
        }
    }
?>