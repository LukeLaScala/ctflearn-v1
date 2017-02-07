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
        <h5 class="orange-text center-align">
        <?php

            echo(htmlspecialchars($user['username']) . "'s solved problems" );

        ?>
        </h5>
    </div>
    <div class="col l8 push-l2">

        <ul class="collapsible" data-collapsible="accordion">
            <?php foreach($problem_list as $problem) { ?>

                <li>
                    <div style="cursor: default;" class="collapsible-header tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo($problem['submission_time'] . ' ET') ?>">
                        <?php echo("<u><a class=\"black-text\" href=index.php?action=lookup_problem&problem_name=" . str_replace(" ", "%20",$problem['problem_name']) . ">" . $problem['problem_name'] . "</a></u>" . htmlspecialchars(" - " . $problem['username'] . " - " . $problem['difficulty'] . "pts")) ?>
                        <span style="float: right"><?php echo(htmlspecialchars($problem['category'] . "  " . get_num_solves($problem['problem_id'])) . "  " . "solves"); ?>
                        </span>
                    </div>

                </li>


            <?php } ?>
        </ul>
    </div>
</div>