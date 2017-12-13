<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="style.css">
  <script src ="changestyle.js"></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body onload="checkCookie()">
<div id="loginbar" class="loginbar">
    Themes:
    <button type="button" class="mybutton" onclick="switchLight()">Light</button>
    <button type="button" class="mybutton" onclick="switchDark()">Dark</button>
    <!-- <span style="float:right">
      Welcome to Nitflux!
      <a class="loginlink" href="https://i.ytimg.com/vi/e9FM-FkDeWs/maxresdefault.jpg">Login</a>
      <a class="loginlink" href="https://i.ytimg.com/vi/e9FM-FkDeWs/maxresdefault.jpg">Sign Up</a>
    </span> -->
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
<div class="main">

  <?php
    require 'db.php';
    if(isset($_GET['movie']))
    {
      $movie = $_GET["movie"];
    # addslashes deals with unusual characters
      $sqlMovie = addslashes($movie);
      try {
        $db = getDB();
        $sql = "SELECT * FROM movies WHERE name='$sqlMovie'";
        $query = $db->prepare($sql);
        $query->execute();
    # i don't know the details of fetch_both, but it does what I want
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

            echo '<h1>' . $title . " (" . $year . ')</h1>';
            echo '<a class=\'bloglink\' style=\'float: right; padding: 1%;
            \' href=\'' . $page . '\'>' . '<img src=\''. $img . '\'></a><br/>';
            break; # only expect one result. just in case of multiples or infinite loops...
          }

        } catch(PDOException $e) {
          echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
      }
      # this field is not necessarily present
      if ($actors != 'null') {
        echo "<h3>Leading actors: ";
        $actorArray = explode(",", $actors);
        for ($i = 0; $i < count($actorArray); $i++) {
            $actor = $actorArray[$i];
            $urlActor = urlencode($actor);
            echo "<a class=\"bloglink\" href=\"http://localhost/nitflux/search.php?actor="
             . $urlActor . "\">" .  $actor . "</a>";
            if ($i != count($actorArray)-1)
              echo ",";
        }
        echo "</h3>";
      }
      # this field is not necessarily present
      if ($genres != 'null') {
        echo "<h3>Tagged genres: ";
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
      # this field is not necessarily present
      if ($dur != 'null')
        echo "<h3>Duration: " . $dur . "</h3>";

      echo "<h4>Synopsis: " . $blurb . "</h4>";

      # gathers all ratings on the movie, computes Average:
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
      # html form, via php in order to include variable $sqlMovie
      echo "</br><strong>Enter your review below:</strong></br></br>";
      echo "<form name=\"comment\" action=\"http://localhost/nitflux/addComment\"
         method=\"post\" style=\"font-weight: bold;\">";
      echo "<input class=\"input\" type=\"hidden\" name=\"movie\" value=\"$movie\">";
      echo "Name: &nbsp;";
      echo "<input class=\"input\" type=\"text\" name=\"reviewer\" maxlength=\"16\" required>";
      echo "</br>";
      echo "Rating: &nbsp;";
      echo "<input class=\"input\" type=\"number\" name=\"rating\" max=\"10\" min=\"1\" required>";
      echo "</br>";
      echo "<input class=\"input\" type=\"text\" name=\"data\" style=\"width: 90%; height: 200px;\"
       maxlength=\"500\" required>";
      
      echo "</br>";
      echo '<div class="g-recaptcha" data-sitekey="6Lcl0DwUAAAAANoiJSKE6wqNIWHXxGlTLmrQXQTu"></div>';
      echo "</br>";
      echo "<input type=\"submit\" class=\"mybutton\" value=\"Submit\">";
      echo "</form>";

      echo "</br></br></br><strong>Previous reviews: </strong> </br></br>";

      // print out all of the current reviews in html format
      try {
        $sqlSelect = "SELECT name,rating,comment FROM reviews where movie='$sqlMovie'";
        $stmt = $db->query($sqlSelect);

        foreach ($stmt as $comment) {
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
      } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
      }

      $db = null;
    ?>
</div>
</br></br></br></br></br>
</body>
</html>
