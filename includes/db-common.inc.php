<?php

include "config.inc.php";

function getConnection() {
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

function runQuery($connection, $sql, $parameters=array()) {
    if (!is_array($parameters)) {
        $parameters = array($parameters);
    }
    
    $statement = null;
    
    if (count($parameters) > 0) {
        $statement = $connection->prepare($sql);
        $success = $statement->execute($parameters);
        
        if (!$success) {
            throw new PDOException;
        }
    } else {
        $statement = $connection->query($sql);
        
        if (!$statement) {
            throw new PDOException;
        }
    }
    
    return $statement;
}

?>