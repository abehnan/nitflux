<?php

    // initialize
    use \Psr\Http\Message\ServerRequestInterface as Request;
    require 'db.php';
    require './vendor/autoload.php';
    $app = new \Slim\App;
    $app->get('/users','getUsers');
    $app->get('/addComment', 'addComment');
    $app->get('/createGenreTable', 'createGenreTable');
    $app->run();

    // call: localhost/nitflux/addComment (using GET method)
    function addComment(Request $request) {
        
        // insert the comment into the database
        try {
            $db = getDB();
            $userInput = $request->getQueryParams();
            $sqlInsert = "INSERT INTO reviews(name, rating, comment) VALUES ('" . $userInput['reviewer'] . "','" . $userInput['rating'] . "','" . $userInput['data'] . "')";
            $stmt = $db->prepare($sqlInsert);
            $stmt->execute();
            $db = null;
        } catch(PDOException $e) {
            echo 'Invalid comment';
        }
    }

    function createGenreTable(Request $request) {
        try {
            $db = getDB();
            $sql = "SELECT name,genres FROM movies";
            $stmt = $db->query($sql);
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
        foreach ($stmt as $row) {
            $name = addslashes($row['name']);
            $genres = explode(",",$row['genres']);
            foreach($genres as $g) {
                if (!empty($g)) {
                    $genre = addslashes($g);
                    $sql = "INSERT INTO genres (genre, movie) VALUE('$genre', '$name')";
                    try {
                        $db->query($sql);
                    } catch(PDOException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}} <br><br>';
                    }
                } 
            }
        }
        $db = null;        
    }

?>