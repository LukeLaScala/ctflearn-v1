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
<body bgcolor="#1565C0">
<?php
if (isset($_SESSION['user']['logged_in']))
    include 'navbarloggedin.php';
else
    include 'navbar.php';

?>

<style>
    .padding-bottom {
        padding-bottom: 30px;
    }
</style>

<br>
<br>
<br>
<br>
<div class="row white-text">
    <div class="col l12 center-align">
        <h1>What is CTFLearn?</h1>
    </div>
</div>


<div class="col l12 white-text center-align">
    <h5>CTFLearn is a new and revolutionary capture the flag practice platform.</h5>
    <h5>Users can upload their own problems instantly that others can solve for points.</h5>
</div>
<br>
<br>


<div class="col l12 white-text center-align">
    <h5><a class="white-text" href="index.php?action=show_add_user">Click here to register!</a></h5>
</div>


</body>
</html>
