<?php

Class Database {

    public static function Connect($HostName, $UserName, $Password, $DatabaseName) {
        try {
            $Connection = new PDO("mysql:host=$HostName;dbname=$DatabaseName", $UserName, $Password);
            return $Connection;
        } catch (PDOException $Exception) {
            return null;
        }
    }

    public static function Disconnect($Connection) {
        $Connection = null;
    }

    public static function Execute($Connection, $SQL) {
        $PreparedStatement = $Connection->prepare($SQL);
        $PreparedStatement->execute();
    }

    public static function Create($Connection, $TableName, $Column, $Data) {
        $SQL = "INSERT INTO `" . $TableName . "` (";
        foreach ($Column as $Value) {
            $SQL = $SQL . "`" . $Value . "`, ";
        }
        $SQL = substr($SQL, 0, -2) . ") VALUES (";
        foreach ($Data as $Value) {
            $SQL = $SQL . $Connection->quote($Value) . ", ";
        }
        $SQL = substr($SQL, 0, -2) . ");";
        $PreparedStatement = $Connection->prepare($SQL);
        $PreparedStatement->execute();
        /* Sample Use/Row Extraction

          $Column = array("playerName", "score", "mode");
          $Data = array("test`Jude```;;;;;.,.,..,`;,;`,.,;`.;,`test", "1000", "normal");
          $Database::Create($Connection, "scores", $Column, $Data);

         */
    }

    public static function Read($Connection, $SQL) {
        $PreparedStatement = $Connection->prepare($SQL);
        $PreparedStatement->execute();
        $Result = $PreparedStatement->fetchAll(PDO::FETCH_ASSOC);
        return $Result;
        /* Sample Use/Row Extraction

          if (!empty($Result)) {
          foreach ($Result as $Row) {
          echo $Row['columnName'];
          }
          } else {
          echo "No Data.";
          }

         */
    }

    public static function Update($Connection, $TableName, $TargetColumn, $NewValue, $ReferenceColumn, $ReferenceValue) {
        $NewValue = $Connection->quote($NewValue);
        if ($ReferenceColumn == null) {
            $SQL = "UPDATE `$TableName` SET `$TargetColumn` = $NewValue;";
        } else {
            $SQL = "UPDATE `$TableName` SET `$TargetColumn` = $NewValue WHERE `$TableName`.`$ReferenceColumn` = '$ReferenceValue';";
        }
        $PreparedStatement = $Connection->prepare($SQL);
        $PreparedStatement->execute();
        /* Sample Use

          $Database::Update($Connection, "tableName", "rowId", "newValue", "", "");
          $Database::Update($Connection, "tableName", "rowId", "newValue", "referenceId", "referenceValue");

         */
    }

    public static function Delete($Connection, $TableName, $ReferenceColumn, $ReferenceValue) {
        if ($ReferenceColumn == null) {
            $SQL = "TRUNCATE `$TableName`;";
        } else {
            $SQL = "DELETE FROM `$TableName` WHERE `$TableName`.`$ReferenceColumn` = $ReferenceValue;";
        }
        $PreparedStatement = $Connection->prepare($SQL);
        $PreparedStatement->execute();
        /* Sample Use

          $Database::Delete($Connection, "tableName", "", "");
          $Database::Delete($Connection, "tableName", "rowId", "1");

         */
    }

}
