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

<?php echo(get_join_group_alerts()); ?>


<div class="container section">
    <h3 style="padding-bottom: 5%" class="orange-text">Password for <?php echo($_GET['group'] . " (" . get_num_users_per_group(get_group_by_name($_GET['group'])['group_id'])) . ")"; ?> </h3>
    <form action="index.php?action=join_group" method="post">
        <div class="input-field valign orange-text">
            <input id="search2" name="password" type="search" required>
            <input type="hidden" value="join_group" name="action">
            <input type="hidden" value="<?php echo($_GET['group']); ?>" name="group">
            <label for="search"><i class="material-icons">done</i></label>
            <i class="material-icons">close</i>
        </div>
    </form>
</div>
</body>
</html>
