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
    <?php include 'head.php' ?>
</head>

<body>
<?php navbar(); ?>
<?php echo(get_submit_flag_alerts()); ?>

<div class="row">
    <div class="col l8 push-l2">
        <h4 class="orange-text center-align">All Problems
        </h4>
        <ul class="collapsible" data-collapsible="accordion">
            <?php foreach ($problem_list as $problem) { ?>
                <li onclick="window.parent.location.href='index.php?action=find_problem_details&problem_id=<?php echo($problem['problem_id']); ?>'">
                    <div class="collapsible-header"><?php echo(htmlspecialchars($problem['problem_name']) . " - " . '<u><a class="black-text" href="index.php?action=show_account&username=' . htmlspecialchars($problem['username']) . '"> ' . htmlspecialchars($problem['username']) . '</a></u>' . " - " . htmlspecialchars($problem['difficulty'])) ?><span style="float: right"><?php echo(htmlspecialchars($problem['category']) . "&nbsp&nbsp&nbsp&nbsp" . get_num_solves($problem['problem_id'])) . "  " . "solves" . "</button"; ?></span></div>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
</body>
