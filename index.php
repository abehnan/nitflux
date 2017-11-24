<?php

    // initialize
    use \Psr\Http\Message\ServerRequestInterface as Request;
    require 'db.php';
    require './vendor/autoload.php';
    $app = new \Slim\App;
    $app->get('/users','getUsers');
    $app->get('/addComment', 'addComment');
    $app->get('/populateGenreTable', 'populateGenreTable');
    $app->get('/populateActorTable', 'populateActorTable');
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

    function populateGenreTable(Request $request) {
        // connect to db and query all movie names and genres from table movies
        try {
            $db = getDB();
            $sql = "SELECT name,genres FROM movies";
            $stmt = $db->query($sql);
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
        foreach ($stmt as $row) {
            // add slashes for special characters
            $movie = addslashes($row['name']);
            // transform string containing comma seperated values into array
            $genres = explode(",",$row['genres']);
            foreach($genres as $g) {
                if (!empty($g)) {
                    // add slashes for special characters
                    $genre = addslashes($g);
                    $sql = "INSERT INTO genres (genre, movie) VALUE('$genre', '$movie')";
                    // insert new values into genre table
                    echo "Executing: " . $sql . "...<br>";
                    try {
                        $db->query($sql);
                    } catch(PDOException $e) {
                        echo 'Error: '. $e->getMessage() .'<br>';
                    } 
                } 
            }
        }
        $db = null;        
    }

    function populateActorTable(Request $request) {
        // connect to db and query all movie names and genres from table movies
        try {
            $db = getDB();
            $sql = "SELECT name,actors FROM movies";
            $stmt = $db->query($sql);
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
        foreach ($stmt as $row) {
            // add slashes for special characters
            $movie = addslashes($row['name']);
            // transform string containing comma seperated values into array
            $actors = explode(",",$row['actors']);
            foreach($actors as $a) {
                if (!empty($a)) {
                    // add slashes for special characters
                    $actor = addslashes($a);
                    $sql = "INSERT INTO actors (actor, movie) VALUE('$actor', '$movie')";
                    // insert new values into genre table
                    echo "Executing: " . $sql . "...<br>";
                    try {
                        $db->query($sql);
                    } catch(PDOException $e) {
                        echo 'Error: '. $e->getMessage() .'<br>';
                    } 
                } 
            }
        }
        $db = null;        
    }

?>