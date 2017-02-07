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
    <?php include 'head.php' ?>
</head>
<body>
<?php
if (isset($_SESSION['user']['logged_in']))
    include 'navbarloggedin.php';
else
    include 'navbar.php';

?>
<?php
echo(get_registration_alerts());
?>
<div class="row">
    <div class="col l6  push-l6">
        <div class="container section">
            <div class="row">
                <div class="col l12 ">
                    <h3>Register</h3>
                    <div class="section"></div>
                    <div class="row"></div>
                    <form action="index.php?action=add_user" method="post">
                        <div class="col l12">
                            <label>Username: </label>
                            <input type="text" name="username" maxlength="24" required>
                            <br>
                        </div>
                        <div class="col l12">
                            <label>Email: </label>
                            <input type="email" name="email" required>
                        </div>
                        <div class="col l12">
                            <label>Password: </label>
                            <input type="password" name="password" required>
                            <br>
                        </div>
                        <div class="col l12">
                            <label>Password (again): </label>
                            <input type="password" name="confirmpassword" required>
                            <br>
                        </div>
                        <div class="col l12">
                            <p>
                                <input type="checkbox" checked="checked" id="test5" name="receive_emails">
                                <label for="test5">Allow the most occasional CTF email updates</label>
                            </p>
                            <br>
                        </div>
                        <br>
                        <div class="col l12">
                            <button type="submit" class="waves-effect waves-light btn orange">Register</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
