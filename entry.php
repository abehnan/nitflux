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
  <div class="blog">
      <?php
      require 'db.php';
      if(isset($_GET['movie']))
      {
        $movie = $_GET["movie"];
        $movie = addslashes($movie);
        try {
          $db = getDB();
          $sql = "SELECT * FROM movies WHERE name='$movie'";
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
            echo '<a href=\'' . $page . '\'>' . '<img src=\''. $img . '\'></a><br/>';
            break; # just in case of multiples or infinite loops...
          }

        } catch(PDOException $e) {
          echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
      }
      // echo "<h3>Leading actors: " . $actors . "</h3>";
      echo "<h3>Leading actors: ";
      $actorArray = explode(",", $actors);
      for ($i = 0; $i < count($actorArray); $i++) {
          $actor = $actorArray[$i];
          $urlActor = urlencode($actor);
          echo "<a href=\"http://localhost/nitflux/search.php?actor=" . $urlActor . "\">" .  $actor . "</a>";
          // echo $urlActor;
          // echo $actorArray[$i];
          if ($i != count($actorArray)-1)
            echo ",";
      }
      echo "</h3>";
      // echo "<h3>Tagged genres: " . $genres . "</h3>";
      echo "<h3>Tagged genres: ";
      $genreArray = explode(",", $genres);
      for ($i = 0; $i < count($actorArray); $i++) {
          $genre = $genreArray[$i];
          $urlGenre = urlencode($genre);
          echo "<a href=\"http://localhost/nitflux/search.php?genre=" . $urlGenre . "\">" .  $genre . "</a>";
          // echo $urlActor;
          // echo $actorArray[$i];
          if ($i != count($genreArray)-1)
            echo ",";
      }
      echo "</h3>";
      echo "<h3>Duration: " . $dur . "</h3>";
      echo "<h4>Synopsis: " . $blurb . "</h4>";

      ?>
      </br>

    <strong>Enter your comment below:</strong>
    </br></br>
    <?php
      echo "<form name=\"comment\" action=\"http://localhost/nitflux/addComment\" method=\"get\" style=\"font-weight: bold;\">";
      echo "<input type=\"hidden\" name=\"movie\" value=\"$movie\">";
      echo "Name: &nbsp;";
      echo "<input type=\"text\" name=\"reviewer\" maxlength=\"16\" required>";
      echo "</br>";
      echo "Rating: &nbsp;";
      echo "<input type=\"number\" name=\"rating\" max=\"10\" min=\"1\" required>";
      echo "</br>";
      echo "<input type=\"text\" name=\"data\" style=\"width: 600px; height: 200px;\" maxlength=\"500\" required>";
      echo "</br>";
      echo "<input type=\"submit\" class=\"mybutton\" value=\"Submit\">";
      echo "</form>"
    ?>

    <!-- <form name="comment" action="http://localhost/nitflux/addComment" method="get" style="font-weight: bold;">
    <input type="hidden" value=$movie>
    Name: &nbsp;
    <input type="text" name="reviewer" maxlength="16">
    </br>
    Rating: &nbsp;
    <input type="text" name="rating" maxlength="2"> / 10
    </br>
    <input type="text" name="data" style="width: 600px; height: 200px;" maxlength="500">
    </br>
    <input type="submit" class="mybutton" value="Submit">
    </form> -->


</br>
</br>
</br>
<strong>Previous comments: </strong>
</br>
<?php
// print out all of the current ratings in html format
try {
  $sqlSelect = "SELECT name,rating,comment FROM reviews where movie=\"$movie\"";
  $stmt = $db->query($sqlSelect);
  $comments = $stmt->fetchAll(PDO::FETCH_OBJ);
  $db = null;
  echo  json_encode($comments);
} catch(PDOException $e) {
  echo '{"error":{"text":'. $e->getMessage() .'}}';
}
?>
</div>
</br></br></br></br></br>
</body>
</html>
