<?php

    // initialize
    use \Psr\Http\Message\ServerRequestInterface as Request;
    require 'db.php';
    require './vendor/autoload.php';
    $app = new \Slim\App;
    $app->get('/users','getUsers');
    $app->get('/addComment', 'addComment');
    $app->get('/showComments', 'showComments');
    $app-
    $app->run();

    // call: localhost/nitflux/addComment (using GET method)
    function addComment(Request $request) {
        
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
    }

?>