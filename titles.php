<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src ="changestyle.js"></script>
</head>

<body>
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
        <span style="font-size: 16px">All Films/Shows by Title</span>
    </div>

    <div id="menubar" class="menubar">
            <a href="./index.html" class="menulink">
                home</a>
            &nbsp;&nbsp;&nbsp;&nbsp; 
            <a href="./titles.php" class="menulink">
                titles</a>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="./comments.php" class="menulink">
                genres</a> 
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="./contact.html" class="menulink">
                contact us</a>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="./comments.php" class="menulink">
                comments</a> 
            &nbsp;&nbsp;&nbsp;&nbsp;
            
        </div>

    <div id="titles" class="blog">
        <h1>Titles</h1>
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
                echo "<li><a href='http://google.ca'>$movie</a></li>";
            }
            $db = null;        
        ?>
        </ul>
    </div>