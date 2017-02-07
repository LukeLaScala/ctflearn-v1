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

<?php echo(get_lookup_user_alerts()); ?>


<div class="container section">
    <h3 style="padding-bottom: 5%" class="orange-text">Search for any user</h3>
    <form action="index.php?" method="get">
        <div class="input-field valign orange-text">
            <input id="search2" name="username" placeholder="Username" type="search" required>
            <input type="hidden" value="show_account" name="action">
        </div>
    </form>
</div>
</body>
</html>
