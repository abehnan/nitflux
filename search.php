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
  <!-- <span style="float:right">
    Welcome to Nitflux!
    <a class="loginlink" href="https://i.ytimg.com/vi/e9FM-FkDeWs/maxresdefault.jpg">Login</a>
    <a class="loginlink" href="https://i.ytimg.com/vi/e9FM-FkDeWs/maxresdefault.jpg">Sign Up</a>
  </span> -->
</div>

  <div id="titlebar" class="titlebar">
    <span style="font-size: 36px">Nitflux&nbsp;</span>
    <br>
    <span style="font-size: 16px">Search Through our Titles!</span>
  </br>
</div>

<div id="menubar" class="menubar">
  <a href="./index.html" class="menulink">home</a>
  &nbsp;&nbsp;&nbsp;&nbsp;
  <a href="./search.php" class="menulink">search</a>
  &nbsp;&nbsp;&nbsp;&nbsp;
  <a href="./about.html" class="menulink">about us</a>
</div>

<div id="titles" class="main">

<div class="column-left">
<span><h4>Search By Actor:</h4>
<form action="search.php" method="GET">
  <input class="input" type="text" name="actor" >
  <br>
  <input class="mybutton" type="submit" value="Search!">
</form></div>

<div class="column-center">
<h4>Search By Genre:</h4>
<form action="search.php" method="GET">
  <input class="input" type="text" name="genre" >
  <br>
  <input class="mybutton" type="submit" value="Search!">
</form></span></div>

<div class="column-right">
<h4>Search By Title:</h4>
<form action="entry.php" method="GET">
  <input class="input" type="text" name="movie" >
  <br>
  <input class="mybutton" type="submit" value="Search!">
</form></span></div>

<?php
  if(isset($_GET['actor'])) {
    echo "<h1>Actor search results for: " . $_GET['actor'] . "</h1>";
  }
  else if (isset($_GET['genre'])) {
    echo "<h1>Genre search results for: " . $_GET['genre'] . "</h1>";
  }
  else {
    echo "<h1>All titles sorted alphabetically</h1>";
  }
?>

<ul><?php
  require 'db.php';
    // print out all of the current ratings in html format
    // connect to db and query all movie names and genres from table movies
    try {
      $db = getDB();
      if(isset($_GET['actor'])) {
        $actor = addslashes($_GET['actor']);
        $sql = "SELECT name FROM actors WHERE actor=\"$actor\"";
      }
      else if (isset($_GET['genre'])) {
        $genre = addslashes($_GET['genre']);
        $sql = "SELECT name FROM genres WHERE genre=\"$genre\"";
      }
      else {
        $sql = "SELECT name FROM movies";
      }
      $stmt = $db->query($sql);
    } catch(PDOException $e) {
      echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
    foreach ($stmt as $row) {
      $movie = $row['name'];

      $urlMovie = urlencode($movie);
      echo "<li><a class=\"bloglink\" href=\"http://localhost/nitflux/entry.php?movie="
       . $urlMovie . "\">" .  $movie . "</a></li>";
    }
    $db = null;
  ?></ul>
</div>
</body>
</html>
