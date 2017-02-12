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
<?php navbar(); ?>

<?php
echo(get_registration_alerts());
echo(get_login_alerts());
?>
<div class="row valign-wrapper">
    <div class="col l6">
        <div class="col l12 grey-text center-align valign hide-on-med-and-down">
            <h5>CTFLearn is a new capture the flag practice platform for beginner and experts.</h5>
            <br>
            <h5>Anyone can: </h5>
            <ul>
                <li>
                    Post Problems
                </li>
                <li>
                    Solve Problems
                </li>
                <li>
                    Post News
                </li>
            </ul>
        </div>


    </div>
    <div class="col l6">
        <div class="container section">
            <div class="row">
                <div class="col l12 ">
                    <h3>Sign Up</h3>
                    <div class="section"></div>
                    <div class="row"></div>
                    <form action="index.php?action=add_user" method="post">
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="username" name="username" type="text" maxlength="24" required>
                                <label for="username">Username</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="email" name="email" type="email" required>
                                <label for="email">Email</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="password" name="password" type="password" required>
                                <label for="password">Password</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="confirmpassword" name="confirmpassword" type="password" required>
                                <label for="confirmpassword">Password (Again)</label>
                            </div>
                        </div>

                        <div class="row">
                            <p>
                                <input type="checkbox" class="filled-in checkbox-orange" id="test5" checked="checked"
                                       name="recieve_emails">
                                <label for="test5">Allow occasional CTF email updates</label>
                            </p>
                        </div>
                        <br>
                        <div class="row">
                            <button type="submit" class="waves-effect waves-light btn orange">Sign Up</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
