<?php
/**
 * Created by PhpStorm.
 * User: luklas
 * Date: 8/4/16
 * Time: 11:23 AM
 */
?>
<html>
<head>
    <?php include 'head.php'?>
</head>
<body>
<?php include 'navbarloggedin.php'; ?>

<div class="row">
    <div class="col l12">
        <h4 class="orange-text center-align">
            <?php echo(htmlspecialchars($user['username'])); ?>
        </h4>
        <h6 class="orange-text center-align">
            Followers
        </h6>
    </div>
    <div class="col l8 push-l2">

        <ul class="collection" data-collapsible="">
            <?php foreach($user_list as $user) { ?>

                <li>
                    <div class="collapsible-header">
                        <u><a class="orange-text" href="index.php?action=show_account&username=<?php echo($user['username']); ?>">
                                <?php echo(htmlspecialchars($user['username'])); ?>
                            </a>
                        </u>
                        <span style="float: right"><?php echo(htmlspecialchars('Hackscore: ' . $user['hackscore'])); ?>
                        </span>
                    </div>

                </li>


            <?php } ?>
        </ul>
    </div>
</div>