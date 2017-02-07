<?php
/**
 * Created by PhpStorm.
 * User: luklas
 * Date: 2/5/17
 * Time: 7:07 PM
 */

?>

<html>
<head>
    <?php include 'head.php'?>
</head>
<body>
<?php
if(isset($_SESSION['user']['logged_in']))
    include 'navbarloggedin.php';
else
    include 'navbar.php';

?>
<?php
echo(get_add_challenge_alerts());
?>

<div class="container section">
    <div class="row">
        <div class="col l8 push-l2">
            <h3>Add some news!</h3>
            <div class="section"></div>
            <form action="index.php?action=add_news" method="post">

                <label for="description">News</label>
                <textarea id="news" name="news" class="materialize-textarea" required></textarea>

                <button type="submit" class="waves-effect waves-light btn orange">Add News</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
