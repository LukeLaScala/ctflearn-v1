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
        <h3 class="orange-text center-align">
            <?php

            echo(htmlspecialchars($user['username']) . "'s added problems" );

            ?>
        </h3>
    </div>
    <div class="col l8 push-l2">

        <ul class="collapsible" data-collapsible="accordion">
            <?php foreach($problem_list as $problem) { ?>

                <li>
                    <div class="collapsible-header" style="cursor: default">
                        <?php echo("<u><a class=\"orange-text\" href='index.php?action=lookup_problem&problem_name=" . str_replace(" ", "%20",$problem['problem_name']) . "'>" . htmlspecialchars($problem['problem_name']) . "</a></u>" . htmlspecialchars(" - " . $problem['username'] . " - " . $problem['difficulty'] . "pts")) ?>
                        <span style="float: right"><?php echo(htmlspecialchars($problem['category'] . "  " . get_num_solves($problem['problem_id'])) . "  " . "solves"); ?>
                        </span>
                    </div>
                    <div class="collapsible-body">
                        <p>
                            <?php echo($problem['problem_description']); ?>
                        </p>
                        <div class="section"></div>

                        <div class="row">
                            <div class="col l2">
                                <?php if($_SESSION['user']['user_id'] === $user['user_id'])
                                    echo(get_html_for_delete_button($problem['pid']));
                                ?>
                            </div>
                            <div class="col l1 valign-wrapper">
                                <a href="index.php?action=show_edit&problem_id=<?php echo($problem['pid']);?>" class="black-text valign"><i class="material-icons">mode_edit</i></a>
                            </div>
                        </div>
                    </div>

                </li>


            <?php } ?>
        </ul>
    </div>
</div>