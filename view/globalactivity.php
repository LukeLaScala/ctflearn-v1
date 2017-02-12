<?php
/**
 * Created by PhpStorm.
 * User: luklas
 * Date: 8/1/16
 * Time: 10:11 AM
 */
?>

<html>
<head>

<?php include 'head.php'; ?>

</head>
<body>

<?php navbar(); ?>

<div class="row">
        <h1 class="center-align" style="margin-bottom: 0;">Activity</h1>
        <h5 class="center-align">from all acounts</h5>
        <p class="center-align"><a href="index.php?action=activity">Switch to your friends activity</a></p>
</div>
    <div class="row container">
        <div class="col l12 s12">
            <ul class="collection with-header">
                <li class="collection-header"><h5>Recent Activity</h5></li>
                <?php foreach (get_recent_activity() as $activity) { ?>
                    <li class="collection-item truncate">
                        <p><span><?php echo(get_username_html($activity['username']) . " " . get_activity_phrase($activity));?></span><span class="right"><?php echo(time_elapsed_string($activity['timestamp'])); ?></span></p>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>


</body>
</html>