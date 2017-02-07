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
<?php include 'navbarloggedin.php'; ?>
<?php echo(get_submit_flag_alerts()); ?>

<div class="row">
    <div class="col l8 push-l2">

        <p class="center-align orange-text">Showing <b>public</b> results
            for: <?php echo(htmlspecialchars($_GET['problem_name']) . ", created by others.") ?></p>

        <ul class="collapsible" data-collapsible="accordion">
            <?php foreach ($problem_list as $problem) {


                if ($problem['correct']) { ?>

                    <li>
                        <div class="collapsible-header">
                            <i class="material-icons black-text">done</i>
                            <?php echo(htmlspecialchars($problem['problem_name'] . " - " . $problem['username'] . " - " . $problem['difficulty'] . "pts")) ?>
                            <span
                                style="float: right"><?php echo(htmlspecialchars($problem['category']) . "  " . get_num_solves($problem['problem_id']) . "  " . "solves"); ?></span>
                        </div>
                        <div class="collapsible-body">
                            <p>
                                <?php echo($problem['problem_description']); ?>
                            </p>
                            <div class="section"></div>

                            <div class="row">
                                <div class="col l4">
                                    <h3 class="orange-text">Solved!</h3>
                                </div>
                            </div>
                        </div>
                    </li>

                    <?php

                } else { ?>

                    <li>
                        <div class="collapsible-header">
                            <i class="material-icons">hi</i><?php echo(htmlspecialchars($problem['problem_name'] . " - " . $problem['username'] . " - " . $problem['difficulty'] . "pts")) ?>
                            <span
                                style="float: right"><?php echo(htmlspecialchars($problem['category'] . "  " . get_num_solves($problem['problem_id'])) . "  " . "solves"); ?></span>
                        </div>
                        <div class="collapsible-body">
                            <p>
                                <?php echo(htmlspecialchars($problem['problem_description'])); ?>
                            </p>
                            <div class="section"></div>

                            <div class="row">
                                <div class="col l4">
                                    <form action="index.php?action=check_submit" method="post">
                                        <label>Flag: </label>
                                        <input type="text" name="flag" required>
                                        <br>
                                        <input type="hidden" value="<?php echo($problem['pid']); ?>" name="problem_id">
                                        <input type="hidden"
                                               value="<?php echo(htmlspecialchars($_GET['problem_name'])) ?>"
                                               name="problem_name">

                                        <button type="submit" class="waves-effect waves-light btn orange">Submit
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>

                <?php }
            }
            ?>
        </ul>
    </div>
</div>
</body>
