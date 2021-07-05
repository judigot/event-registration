<?php

Class Tools {

    public static function resetRowCount($Data, $Index) {
        for ($i = 0; $i < sizeof($Data); $i++) {
            $Data[$i][array_keys($Data[0])[$Index]] = $i + 1;
        }
        return $Data;
    }

    public static function downloadCSV($Data) {
        $Data = self::resetRowCount($Data, 0);
        // Insert Column Names into the Array ($Data)
        array_unshift($Data, array_keys($Data[0]));
        self::createFile(true, $Data, null, "Test", "csv");
    }

    public static function exportCSV($Data) {
        $Data = self::resetRowCount($Data, 0);
        // Insert Column Names into the Array ($Data)
        array_unshift($Data, array_keys($Data[0]));
        $Path = getenv("HOMEDRIVE") . getenv("HOMEPATH") . "/Desktop/";
        self::createFile(false, $Data, $Path, "Test", "csv");
    }

    public static function createFile($isDownloadable, $Content, $Location, $FileName, $FileType) {
        $FileType = strtolower($FileType);
        if ($isDownloadable == true) {
            header("Content-type: application/$FileType");
            header("Content-disposition: attachment; filename=$FileName.$FileType");
            $File = fopen('php://output', 'w');
        } else {
            $File = fopen("$Location\\$FileName.$FileType", 'w');
        }

        switch ($FileType) {
            case "csv":
                foreach ($Content as $Value) {
                    //MySQL Data to CSV
                    fputcsv($File, $Value);
                    //Array Data to CSV
                    //fputcsv($File,explode(',',$Value));
                }
                break;
        }
        fclose($File);
    }

}
