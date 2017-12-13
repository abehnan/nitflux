<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="style.css">
  <script src="changestyle.js"></script>
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
    <span style="font-size: 16px">A website created to rate and review original Netflix content.</span>
  </div>

  <div id="menubar" class="menubar">
    <a href="./index.html" class="menulink">home</a>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="./search.php" class="menulink">search</a>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="./about.html" class="menulink">about us</a>
  </div>

  <div id="main" class="main">
    </br>
    <h2> Welcome To NitFlux! </h2>
    <h3> Here are some of our user reviews: </h3>
    </br>
<?php
require 'db.php';
      try {
          $db = getDB();
          $sql ="SELECT DISTINCT * FROM reviews ORDER BY RAND() LIMIT 3";
          $stmt = $db->query($sql);

      foreach ($stmt as $comment){
        $y = $comment['movie'];
        $sql2="SELECT * FROM `movies` WHERE name='$y' ";
        $query = $db->prepare($sql2);
        $query->execute();
        while($result = $query->fetch(PDO::FETCH_BOTH)){

        echo "<div style=\"border-style: groove; padding: 1%;\">";
        echo '<a class=\'bloglink\' style=\'float: right;\' href=\'' .
        $result['page'] . '\'>' . '<img src=\''. $result['img'] . '\'
        style="width:150px;height:85px;"></a><br/>';
        echo "<strong>Name: &nbsp </strong>";
        echo $comment['name'];
        echo "</br>";
        echo "<strong>Rating: &nbsp</strong>";
        echo $comment['rating'];
        echo "</br><strong>Comment:&nbsp</strong>";
        echo $comment['comment'];
        echo "</div></br>";
        break;
      }
    }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
?>

  </div>
</body>

</html>
