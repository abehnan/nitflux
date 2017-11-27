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
  <a href="." class="menulink">
    home</a>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="./search.php" class="menulink">
      search</a>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <a href="./about.html" class="menulink">
        about us</a>
      </div>

      <?php
      require 'db.php';
      if(isset($_POST['submit']))
      {
        $movie = $_POST["title"];
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

            # opportunity for styling these pices of info
            echo '<h1>' . $title . '</h1>';
            echo '<a href=\'' . $page . '\'>' . '<img src=\''. $img . '\'></a><br/>';
            break; # just in case of multiples or infinite loops...
          }

        } catch(PDOException $e) {
          echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
      }
      echo "<h3>Leading actors: " . $actors . "</h3>";
      echo "<h3>Tagged genres: " . $genres . "</h3>";
      echo "<h4>Synopsis: " . $blurb . "</h4>";

      ?>
      <div id="main" class="main">
      </br>

      <strong>Enter your comment below:</strong>
    </br></br>
    <form name="comment" action="http://localhost/nitflux/addComment" method="get" style="font-weight: bold;">
      Name: &nbsp;
      <input type="text" name="reviewer" maxlength="16">
    </br>
    Rating: &nbsp;
    <input type="text" name="rating" maxlength="2"> / 10
  </br>
  <input type="text" name="data" style="width: 600px; height: 200px;" maxlength="500">
</br>
<input type="submit" class="mybutton" value="Submit">
</form>
<div id="commentResult">

</div>
</br>
</br>
</br>
<strong>Previous comments: </strong>
</br>
<?php
// print out all of the current ratings in html format
try {
  $sqlSelect = "SELECT name,rating,comment FROM reviews";
  $stmt = $db->query($sqlSelect);
  $comments = $stmt->fetchAll(PDO::FETCH_OBJ);
  $db = null;
  echo  json_encode($comments);
} catch(PDOException $e) {
  echo '{"error":{"text":'. $e->getMessage() .'}}';
}
?>
</div>
</body>
</html>
