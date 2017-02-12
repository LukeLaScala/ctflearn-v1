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
<?php
echo(get_require_login_alerts());
echo(get_login_alerts());
echo(get_registration_alerts());
?>

<div class="container section">
    <div class="row">
        <div style="padding-bottom: 10px;" class="col l8 push-l2">
            <h3>Login</h3>
            <div class="section"></div>
            <form style="display: inline;" action="index.php?action=login" method="post">
                <label>Username: </label>
                <input type="text" name="username" required autocomplete="off">
                <br>
                <label>Password: </label>
                <input type="password" name="password" required autocomplete="off">
                <br>
                <button type="submit" class="waves-effect waves-light btn orange">Login</button>
            </form>
            <a href="index.php?action=show_add_user"><button class="waves-effect waves-light btn orange">Register</button></a>
        </div>
    </div>
</div>
</body>
</html>
