<?php
/**
 * Created by PhpStorm.
 * User: luklas
 * Date: 7/31/16
 * Time: 10:36 PM
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


<div class="container section">
    <h3 style="padding-bottom: 5%" class="grey-text">Search for any problem</h3>
    <form action="index.php?" method="get">
        <div class="input-field">
            <input id="search2" name="problem_name" placeholder="Problem" type="search" required>
            <input type="hidden" value="lookup_problem" name="action">
        </div>
    </form>
</div>
</body>
</html>
