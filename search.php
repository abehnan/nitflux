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

      <div id="titles" class="blog">
        <h4>Element to make: search by actor or genre (from drop-down form)
          text entry, search/submit button.</h4>
          <h1>All titles sorted alphabetically:</h1>
          <ul>
            <?php
            require 'db.php';
            // print out all of the current ratings in html format
            // connect to db and query all movie names and genres from table movies
            try {
              $db = getDB();
              $sql = "SELECT name FROM movies";
              $stmt = $db->query($sql);
            } catch(PDOException $e) {
              echo '{"error":{"text":'. $e->getMessage() .'}}';
            }
            foreach ($stmt as $row) {
              $movie = $row['name'];
              // add slashes for special characters
              // transform string containing comma seperated values into array
              echo "<li>
              <form method=\"get\" action=\"./entry.php\">
               <input type=\"hidden\" name=\"title\" value=\"$movie\">
              <input type=\"submit\" name=\"submit\" value=\"$movie\">
              </form>
              </li>";
            }
            $db = null;
            ?>
          </ul>
        </div>

      </body>
      </html>
