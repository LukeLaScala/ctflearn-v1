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
    <div class="col l8 push-l2">
        <a class='dropdown-button btn orange' href='#' data-activates='categories'>Categories</a>

        <!-- Dropdown Structure -->
        <ul id='categories' class='dropdown-content'>
            <li><a href="#!">Binary</a></li>
            <li><a href="#!">Cryptography</a></li>
            <li><a href="#!">Forensics</a></li>
            <li><a href="#!">Miscellaneous</a></li>
            <li><a href="#!">Web Exploitation</a></li>
            <li><a href="#!">Programming</a></li>

        </ul>

    </div>
    <div class="col l8 push-l2">

        <ul class="collapsible" data-collapsible="accordion">
            <?php foreach($problem_list as $problem) {
                if($problem['correct']){ ?>

                    <li>
                    <div class="collapsible-header"><i class="material-icons black-text">done</i><?php echo(htmlspecialchars($problem['problem_name'] . " - " . $problem['username'] . " - " . $problem['difficulty'])) ?><span style="float: right"><?php echo(htmlspecialchars($problem['category'])  . "  " . get_num_solves($problem['problem_id']) . "  " . "solves"); ?></span></div>
    <div class="collapsible-body">
        <p>
            <?php echo($problem['problem_description']); ?>
        </p>
        <div class="section"></div>

        <div class="row">
            <div class="col l4">
                <form action="index.php?action=check_submit">
                    <label>Flag: </label>
                    <input type="text" name="flag" required>
                    <br>
                    <input type="hidden" value="<?php echo($problem['problem_id']); ?>">
                    <button type="submit" class="waves-effect waves-light btn orange">Submit</button>
                </form>
            </div>
        </div>
    </div>
    </li>

                <?php

                } else { ?>

                    <li>
                    <div class="collapsible-header"><i class="material-icons">hi</i><?php echo(htmlspecialchars($problem['problem_name'] . " - " . $problem['username'] . " - " . $problem['difficulty'])) ?><span style="float: right"><?php echo(htmlspecialchars($problem['category'] . "  " . get_num_solves($problem['problem_id'])) . "  " . "solves"); ?></span></div>
    <div class="collapsible-body">
        <p>
            <?php echo(htmlspecialchars($problem['problem_description'])); ?>
        </p>
        <div class="section"></div>

        <div class="row">
            <div class="col l4">
                <form action="index.php?action=check_submit">
                    <label>Flag: </label>
                    <input type="text" name="flag" required>
                    <br>
                    <input type="hidden" value="<?php echo($problem['problem_id']); ?>">
                    <button type="submit" class="waves-effect waves-light btn orange">Submit</button>
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
