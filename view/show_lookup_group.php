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

<?php echo(get_lookup_group_alerts()); ?>


<div class="container section">
    <h3 style="padding-bottom: 5%" class="orange-text">Search for any group</h3>
    <form action="index.php?" method="get">
        <div class="input-field valign orange-text">
            <input id="search2" name="group" placeholder="CTF Club" type="search" required>
            <input type="hidden" value="show_group" name="action">
            <label for="search"><i class="material-icons">search</i></label>
            <i class="material-icons">close</i>
        </div>
    </form>
</div>
</body>
</html>
