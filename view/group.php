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
<?php echo(get_join_group_alerts()); ?>
<?php echo(get_add_challenge_alerts()); ?>



<div class="row">
    <div class="col l8 push-l2">
        <br>
        <a class='dropdown-button btn orange' href='#' data-activates='categories'>Sort Challenges</a>
        <button class="dropdown-button btn orange" onclick="window.parent.parent.location.href='index.php?action=show_add_challenge&group_id=<?php echo($group['group_id']) ?>'">Add Challenges</button>
        <button class="dropdown-button btn orange" onclick="window.parent.parent.location.href='index.php?action=show_scoreboard&group_id=<?php echo($group['group_id']) ?>'">Scoreboard</button>

        <!-- Dropdown Structure -->
        <ul id='categories' class='dropdown-content'>

            <li><a href="index.php?action=show_group&sort=all&group=<?php echo(htmlspecialchars($_GET['group'])); ?>">All</a></li>
            <li><a href="index.php?action=show_group&sort=binary&group=<?php echo(htmlspecialchars($_GET['group'])); ?>">Binary</a></li>
            <li><a href="index.php?action=show_group&sort=crypto&group=<?php echo(htmlspecialchars($_GET['group'])); ?>">Cryptography</a></li>
            <li><a href="index.php?action=show_group&sort=forensics&group=<?php echo(htmlspecialchars($_GET['group'])); ?>">Forensics</a></li>
            <li><a href="index.php?action=show_group&sort=misc&group=<?php echo(htmlspecialchars($_GET['group'])); ?>">Miscellaneous</a></li>
            <li><a href="index.php?action=show_group&sort=web&group=<?php echo(htmlspecialchars($_GET['group'])); ?>">Web Exploitation</a></li>
            <li><a href="index.php?action=show_group&sort=programming&group=<?php echo(htmlspecialchars($_GET['group'])); ?>">Programming</a></li>


        </ul>

    </div>
    <div class="col l8 push-l2">

        <ul class="collapsible" data-collapsible="accordion">
            <?php foreach($problem_list as $problem) {


                if ($problem['correct']){ ?>
                    <li>
                        <div class="collapsible-header">
                            <i class="material-icons black-text">done</i>
                            <?php echo(htmlspecialchars($problem['problem_name']) . " - " . "<a class=\"orange-text\" href=\"index.php?action=show_account&username=" . htmlspecialchars($problem['username']) . "\">" . htmlspecialchars($problem['username']) . "</a>". " - " . $problem['difficulty'] . "pts") ?><span style="float: right"><?php echo(htmlspecialchars($problem['category'])  . "  " . get_num_solves($problem['problem_id']) . "  " . "solves"); ?></span></div>
                        <div class="collapsible-body">
                            <p>
                                <?php echo($problem['problem_description']); ?>
                            </p>
                            <div class="section"></div>

                            <div class="row">
                                <div class="col l12">
                                    <h3 class="orange-text">Solved!</h3>
                                </div>
                            </div>


                        <div class="row">
                            <div class="col l14">
                                <?php if($_SESSION['user']['admin'] or is_leader_of_group($_SESSION['user']['user_id'], $group['group_id']))
                                    echo(get_html_for_delete_button($problem['pid']));
                                ?>
                            </div>
                        </div>
                        </div>


                    </li>


                    <?php

                } else if($problem['user_id'] == $_SESSION['user']['user_id']){ ?>

                    <li>
                        <div class="collapsible-header">
                            <i class="material-icons black-text">done</i>
                            <?php echo(htmlspecialchars($problem['problem_name']) . " - " . "<a class=\"orange-text\" href=\"index.php?action=show_account&username=" . htmlspecialchars($problem['username']) . "\">" . htmlspecialchars($problem['username']) . "</a>" . " - " . $problem['difficulty'] . "pts") ?><span style="float: right"><?php echo(htmlspecialchars($problem['category'])  . "  " . get_num_solves($problem['problem_id']) . "  " . "solves"); ?></span></div>
                        <div class="collapsible-body">
                            <p>
                                <?php echo($problem['problem_description']); ?>
                            </p>
                            <div class="section"></div>

                            <div class="row">
                                <div class="col l14">
                                    <h3 class="orange-text">Created by you</h3>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col l14">
                                    <?php if($_SESSION['user']['admin'] or is_leader_of_group($_SESSION['user']['user_id'], $group['group_id']))
                                        echo(get_html_for_delete_button($problem['pid']));
                                    ?>
                                </div>
                            </div>


                        </div>

                     </li>



                    <?php } else {  ?>

                    <li>
                        <div class="collapsible-header">
                            <i class="material-icons">hi</i><?php echo(htmlspecialchars($problem['problem_name']) . " - " . "<a class=\"orange-text\" href=\"index.php?action=show_account&username=" . htmlspecialchars($problem['username']) . "\">" . htmlspecialchars($problem['username']) . "</a>" . " - " . $problem['difficulty'] . "pts") ?><span style="float: right"><?php echo(htmlspecialchars($problem['category'] . "  " . get_num_solves($problem['problem_id'])) . "  " . "solves"); ?></span></div>
                        <div class="collapsible-body">
                            <p>
                                <?php echo(htmlspecialchars($problem['problem_description'])); ?>
                            </p>
                            <div class="section"></div>

                            <div class="row">
                                <div class="col l12">
                                    <?php // if(!$problem['user_id'] == $_SESSION['user']['user_id']) { ?>
                                    <form action="index.php?action=check_submit" method="post">
                                        <label>Flag: </label>
                                        <input type="text" name="flag" required>
                                        <br>
                                        <input type="hidden" value="<?php echo($problem['pid']); ?>" name="problem_id">
                                        <input type="hidden" value="1" name="group_submit">
                                        <input type="hidden" value="<?php echo(htmlspecialchars($problem['problem_name'])) ?>" name="problem_name">

                                        <button type="submit" class="waves-effect waves-light btn orange">Submit</button>
                                    </form>
                                    <?php // } ?>
                                </div>
                            </div>

                        <div class="row">
                            <div class="col l14">
                                <?php if($_SESSION['user']['admin'] or is_leader_of_group($_SESSION['user']['user_id'], $group['group_id']))
                                    echo(get_html_for_delete_button($problem['pid']));
                                ?>
                            </div>
                        </div>
                        </div>

                    </li>


                <?php }
            }
            ?>
        </ul>

        <button data-target="modal1" class="btn modal-trigger orange">Leave Group</button>

    </div>

    <!-- Modal Structure -->
    <div id="modal1" class="modal bottom-sheet">
        <div class="modal-content">
            <h4>Leaving group?</h4>
            <p>You will not be able to rejoin unless you have the password! Group leader will go to the oldest member.</p>
        </div>
        <div class="modal-footer">
            <a class="white-text" href="index.php?action=leave_group&group_id=<?php echo($group['group_id']); ?>"><button class="waves-effect waves-light btn orange">Leave group!</button></a> 
        </div>
    </div>
</div>
<?php
if(isset($_SESSION['user']['logged_in']))
    include 'footerloggedin.php';
else
    include 'navbar.php';
?>
</body>


</html>


