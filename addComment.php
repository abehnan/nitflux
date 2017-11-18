<?php
    require 'db.php';
    // insert the comment into the database
    try {
        $db = getDB();
        $userInput = $request->getQueryParams();
        $sqlInsert = "INSERT INTO Comments(reviewer, rating, data) VALUES ('" . $userInput['reviewer'] . "','" . $userInput['rating'] . "','" . $userInput['data'] . "')";
        $stmt = $db->prepare($sqlInsert);
        $stmt->execute();
        $db = null;
    } catch(PDOException $e) {
        echo 'Invalid comment';
    }
?>