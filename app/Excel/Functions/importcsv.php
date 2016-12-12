<?php

class CsvImport extends \Maatwebsite\Excel\Files\ExcelFile {

    public function getFile()
    {
        return storage_path('Excel/Imports') . '/project.csv';
    }

    public function getFilters()
    {
        return [
            'chunk'
        ];
    }

}

