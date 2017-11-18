<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div id="loginbar" class="loginbar">
        Themes:
        <a class="loginlink" href="https://www.pathofexile.com/login">Light</a>
        <a class="loginlink" href="https://www.pathofexile.com/login">Dark</a>
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
        <a href="https://www.homedepot.ca/en/home.html" class="menulink">
            home</a>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="https://www.mtlblog.com/" class="menulink">
            titles</a>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="http://www.thefreedictionary.com/physical+contact" class="menulink">
            contact us</a>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="http://www.thefreedictionary.com/physical+contact" class="menulink">
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
            <input type="submit" value="Submit">
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
                $sqlSelect = "SELECT reviewer,rating,data FROM Comments";
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