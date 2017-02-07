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
    echo(get_add_group_alerts());
    if(isset($_SESSION['user']['logged_in']))
        include 'navbarloggedin.php';
    else
        include 'navbar.php';

    ?>

        <div class="container section">
            <div class="row">
                <div class="col l8 push-l2">
                    <h3>Add A Group</h3>
                    <div class="section"></div>
                    <form action="index.php?action=add_group" method="post">
                        <label>Group Name: </label>
                        <input type="text" name="group_name" pattern=".{0,30}" title="30 or less characters" required>
                        <br
                        <label>Password: </label>
                        <input type="text" name="password" required>
                        <br>
                        <button type="submit" class="waves-effect waves-light btn orange">Add a group</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
