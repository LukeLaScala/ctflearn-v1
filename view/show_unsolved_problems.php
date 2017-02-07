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
<?php echo(get_submit_flag_alerts()); ?>
<?php $problem_id = ""; ?>

<script>
    function myFunction(pid){

    }
</script>

<?php echo(get_submit_flag_alerts()); ?>
<div class="row">
    <div class="col l8 push-l2">
        <br>
        <div class="center-align">
            <p class="grey-text grey-lighten-3">Have some costs to offset |: </p>
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- gsfgdd -->
            <ins class="adsbygoogle"
                 style="display:inline-block;width:728px;height:90px"
                 data-ad-client="ca-pub-4379021343880694"
                 data-ad-slot="8106565564"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
        <br>
        <a class='dropdown-button btn orange' href='#' data-activates='categories'>Filter By Category</a>

        <!-- Dropdown Structure -->
        <ul id='categories' class='dropdown-content'>

            <li><a href="index.php?action=show_unsolved_problems&sort=all">All</a></li>
            <li><a href="index.php?action=show_unsolved_problems&sort=binary">Binary</a></li>
            <li><a href="index.php?action=show_unsolved_problems&sort=crypto">Cryptography</a></li>
            <li><a href="index.php?action=show_unsolved_problems&sort=forensics">Forensics</a></li>
            <li><a href="index.php?action=show_unsolved_problems&sort=misc">Miscellaneous</a></li>
            <li><a href="index.php?action=show_unsolved_problems&sort=web">Web Exploitation</a></li>
            <li><a href="index.php?action=show_unsolved_problems&sort=programming">Programming</a></li>

        </ul>
        <a class='btn orange' href='index.php?action=show_add_challenge'>Add Challenge</a>
    </div>
    <div class="col l8 push-l2 row">

        <ul class="collapsible">
            <?php foreach($problem_list as $problem) { ?>

                    <li onclick="window.parent.location.href='index.php?action=find_problem_details&problem_id=<?php echo($problem['pid']); ?>'">
                        <div class="collapsible-header"><?php echo(htmlspecialchars($problem['problem_name']) . " - " . '<u><a class="black-text" href="index.php?action=show_account&username=' . htmlspecialchars($problem['username']) . '"> ' . htmlspecialchars($problem['username']) . '</a></u>' . " - " . htmlspecialchars($problem['difficulty'])) ?><span style="float: right"><?php echo(htmlspecialchars($problem['category']) . "&nbsp&nbsp&nbsp&nbsp" . get_num_solves($problem['pid'])) . "  " . "solves" . "</button"; ?></span></div>
                    </li>
            <?php } ?>
        </ul>
    </div>
</div>

<!-- Modal Structure -->
<div id="modal1" class="modal modal-fixed-footer">
    <div class="modal-content">
        <h4>Modal Header</h4>
        <p>A bunch of text</p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Agree</a>
    </div>
</div>