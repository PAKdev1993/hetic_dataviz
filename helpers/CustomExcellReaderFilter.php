<?php
    require "./vendor/autoload.php";

    use \PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

    /**  Define a Read Filter class implementing \PhpOffice\PhpSpreadsheet\Reader\IReadFilter  */
    class CustomExcellReaderFilter implements IReadFilter
    {
        public function readCell($column, $row, $worksheetName = '') {
            //  Read rows 1 to 7 and columns A to E only
            if ($row >= 1 && $row <= 50) {
                if (in_array($column,range('A','E'))) {
                    return true;
                }
            }
            return false;
        }
    }