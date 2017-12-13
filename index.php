<?php

    // initialize
    use \Psr\Http\Message\ServerRequestInterface as Request;
    require 'db.php';
    require './vendor/autoload.php';
    $app = new \Slim\App;
    $app->get('/users','getUsers');
    $app->post('/addComment', 'addComment');
    $app->get('/randomComments', 'randomComments');
    $app->get('/populateGenreTable', 'populateGenreTable');
    $app->get('/populateActorTable', 'populateActorTable');
    $app->run();

    // call: localhost/nitflux/addComment (using GET method)
    function addComment(Request $request) {

        $postData = $request->getParsedBody();
        // our secret key for recaptcha
        $secret = "6Lcl0DwUAAAAAPP8rkpACT49RO7UBUOkTxe9wBpV";

        // check recaptcha has been done 
        if(isset($postData['g-recaptcha-response']) && !empty($postData['g-recaptcha-response'])) {
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$postData['g-recaptcha-response']);
            $responseData = json_decode($verifyResponse);
            if ($responseData->success) {
                // insert the comment into the database
                try {
                    $db = getDB();
                    // $userInput = $request->getQueryParams();
                    $sqlInsert =
                        "INSERT INTO reviews(name, rating, comment, movie) VALUES ('" .
                        addslashes($postData['reviewer']) . "','" .
                        addslashes($postData['rating']) . "','" .
                        addslashes($postData['data']) . "','" .
                        addslashes($postData['movie']) . "')";

                    $stmt = $db->prepare($sqlInsert);
                    $stmt->execute();
                    $db = null;
                    $movie = print_r($postData['movie'], true);
                    $urlMovieName = urlencode($movie);

                    // redirect to the page that called the function
                    ob_start();
                    header('Location: http://localhost/nitflux/entry.php?movie='
                    . $urlMovieName . "&submit=" . $urlMovieName);
                    ob_end_flush();
                    die();
                } catch(PDOException $e) {
                    echo '{"error":{"text":'. $e->getMessage() .'}}';
                }
            }
            else {
                echo "reCAPTCHA verification failed. Please try again.";
            }
        }
        else {
            echo "reCAPTCHA field is mandatory. Please try again.";
        }
    }

    # trying to print comments
    function randomComments(){
      try {
          $db = getDB();
          $sql ="SELECT DISTINCT * FROM reviews ORDER BY RAND() LIMIT 3";
          $stmt = $db->query($sql);
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
      foreach ($stmt as $comment){
        echo "<div style=\"border-style: groove; padding: 10px;\">";
        echo "<strong>Name: &nbsp </strong>";
        echo $comment['name'];
        echo "</br>";
        echo "<strong>Rating: &nbsp</strong>";
        echo $comment['rating'];
        echo "</br><strong>Comment:&nbsp</strong>";
        echo $comment['comment'];
        echo "</div></br>";
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
                    $sql = "INSERT INTO genres (genre, name) VALUE('$genre', '$movie')";
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
                    $sql = "INSERT INTO actors (actor, name) VALUE('$actor', '$movie')";
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
