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
            <a class="loginlink" href="https://www.pathofexile.com/login">Login</a>
            <a class="loginlink" href="https://www.pathofexile.com/account/create">Sign Up</a>
        </span>
    </div>

    <div id="titlebar" class="titlebar">
        <span style="font-size: 36px">Nitflux&nbsp;</span>
        </br>
        <span style="font-size: 16px">A website created to rate and review original Netflix content.</span>
    </div>

    <div id="menubar" class="menubar">
    <a href="./index.html" class="menulink">
        home</a>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="./titles.php" class="menulink">
        titles</a>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="./genres.html" class="menulink">
        genres</a>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="./about.html" class="menulink">
        about us</a>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="./comments.php" class="menulink">
        comments</a>
    &nbsp;&nbsp;&nbsp;&nbsp;

</div>

    <div id="main" class="main">
        </br>
        </br>
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
            require 'db.php';
            // print out all of the current ratings in html format
            try {
                $db = getDB();
                $sqlSelect = "SELECT name,rating,comment FROM reviews";
                $stmt = $db->query($sqlSelect);

                $comments = $stmt->fetchAll(PDO::FETCH_OBJ);
                $db = null;
                echo  json_encode($comments);
            } catch(PDOException $e) {
                echo '{"error":{"text":'. $e->getMessage() .'}}';
            }
        ?>
    <br><br>
        <form action="http://localhost/nitflux/populateGenreTable" method="get">
            <input type="submit" value="Populate Genre Table">
        </form>

        <form action="http://localhost/nitflux/populateActorTable" method="get">
            <input type="submit" value="Populate Actor Table">
        </form>
    </div>
</body>

</html>
