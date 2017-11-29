<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="style.css">
  <script src ="changestyle.js"></script>
</head>

<body onload="checkCookie()">
<div id="loginbar" class="loginbar">
    Themes:
    <button type="button" class="mybutton" onclick="switchLight()">Light</button>
    <button type="button" class="mybutton" onclick="switchDark()">Dark</button>
    <span style="float:right">
      Welcome to Nitflux!
      <a class="loginlink" href="https://i.ytimg.com/vi/e9FM-FkDeWs/maxresdefault.jpg">Login</a>
      <a class="loginlink" href="https://i.ytimg.com/vi/e9FM-FkDeWs/maxresdefault.jpg">Sign Up</a>
    </span>
  </div>

<div id="titlebar" class="titlebar">
  <span style="font-size: 36px">Nitflux&nbsp;</span>
  </br>
</div>

<div id="menubar" class="menubar">
  <a href="./index.html" class="menulink">home</a>
  &nbsp;&nbsp;&nbsp;&nbsp;
  <a href="./search.php" class="menulink">search</a>
  &nbsp;&nbsp;&nbsp;&nbsp;
  <a href="./about.html" class="menulink">about us</a>
</div>
<div style="margin-left=300px;" class="main">
  <?php
    require 'db.php';
    if(isset($_GET['movie']))
    {
      $movie = $_GET["movie"];
      $sqlMovie = addslashes($movie);
      try {
        $db = getDB();
        $sql = "SELECT * FROM movies WHERE name='$sqlMovie'";
        $query = $db->prepare($sql);
        $query->execute();
          # i don't know the details of fetch_both, but this does what I want
          while($result = $query->fetch(PDO::FETCH_BOTH))
          {
            $img = $result['img'];
            $title = $result['name'];
            $page = $result['page'];
            $actors = $result['actors'];
            $genres = $result['genres'];
            $blurb = $result['synopsis'];
            $dur = $result['duration'];
            $year = $result['year'];

            # opportunity for styling these pices of info
            echo '<h1>' . $title . " (" . $year . ')</h1>';
            echo '<a class=\'bloglink\' style=\'float: right; padding: 1%;\' href=\'' . $page . '\'>' . '<img src=\''. $img . '\'></a><br/>';
            break; # just in case of multiples or infinite loops...
          }

        } catch(PDOException $e) {
          echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
      }
      if ($actors != 'null') {
        // echo "<h3>Leading actors: " . $actors . "</h3>";
        echo "<h3>&nbsp;&nbsp;&nbsp;&nbsp;Leading actors: ";
        $actorArray = explode(",", $actors);
        for ($i = 0; $i < count($actorArray); $i++) {
            $actor = $actorArray[$i];
            $urlActor = urlencode($actor);
            echo "<a class=\"bloglink\" href=\"http://localhost/nitflux/search.php?actor=" . $urlActor . "\">" .  $actor . "</a>";
            // echo $urlActor;
            // echo $actorArray[$i];
            if ($i != count($actorArray)-1)
              echo ",";
        }
        echo "</h3>";
      }
      if ($genres != 'null') {
        // echo "<h3>Tagged genres: " . $genres . "</h3>";
        echo "<h3>&nbsp;&nbsp;&nbsp;&nbsp;Tagged genres: ";
        $genreArray = explode(",", $genres);
        for ($i = 0; $i < count($genreArray); $i++) {
            $genre = $genreArray[$i];
            $urlGenre = urlencode($genre);
            echo "<a class=\"bloglink\" href=\"http://localhost/nitflux/search.php?genre=" . $urlGenre . "\">" .  $genre . "</a>";
            // echo $urlActor;
            // echo $actorArray[$i];
            if ($i != count($genreArray)-1)
              echo ",";
        }
        echo "</h3>";
      }

      if ($dur != 'null')
        echo "<h3>&nbsp;&nbsp;&nbsp;&nbsp;Duration: " . $dur . "</h3>";

      echo "<h4>&nbsp;&nbsp;&nbsp;&nbsp;Synopsis: " . $blurb . "</h4>";
      
      try {
        $sql = "SELECT AVG(rating) AS avgRating FROM reviews WHERE movie='$sqlMovie'";
        $stmt = $db->query($sql);
        foreach ($stmt as $row) {
          $avgRating = $row['avgRating'];
          if (!is_null($avgRating))
            echo "<h4> Average Rating: $avgRating </h4>";
        }
      } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
      }

      echo "</br><strong>Enter your review below:</strong></br></br>";
      echo "<form name=\"comment\" action=\"http://localhost/nitflux/addComment\" method=\"get\" style=\"font-weight: bold;\">";
      echo "<input class=\"input\" type=\"hidden\" name=\"movie\" value=\"$sqlMovie\">";
      echo "Name: &nbsp;";
      echo "<input class=\"input\" type=\"text\" name=\"reviewer\" maxlength=\"16\" required>";
      echo "</br>";
      echo "Rating: &nbsp;";
      echo "<input class=\"input\" type=\"number\" name=\"rating\" max=\"10\" min=\"1\" required>";
      echo "</br>";
      echo "<input class=\"input\" type=\"text\" name=\"data\" style=\"width: 90%; height: 200px;\" maxlength=\"500\" required>";
      echo "</br>";
      echo "<input type=\"submit\" class=\"mybutton\" value=\"Submit\">";
      echo "</form>";

      echo "</br></br></br><strong>Previous review: </strong> </br>";
  
      // print out all of the current ratings in html format
      try {
        $sqlSelect = "SELECT name,rating,comment FROM reviews where movie='$sqlMovie'";
        $stmt = $db->query($sqlSelect);
        $comments = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        echo  json_encode($comments);
      } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
      }

      $db = null;
    ?>
</div>
</br></br></br></br></br>
</body>
</html>
