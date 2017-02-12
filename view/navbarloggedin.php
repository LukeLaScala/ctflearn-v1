<?php
/**
 * Created by PhpStorm.
 * User: hirok
 * Date: 11/18/2016
 * Time: 1:57 PM
 */
?>

<div class="navbar-fixed">
    <nav>
        <div class="nav-wrapper blue row">
            <div class="col l1">
                <a href="index.php" class="brand-logo">&nbsp; &nbsp; CTFLearn</a>
            </div>


            <ul class="right hide-on-med-and-down">
                <li><a href="index.php?action=global_activity"><i
                                class="material-icons left">trending_up</i>Activity</a>
                </li>

                <li><a href="index.php?action=scoreboard"><i class="material-icons left">view_list</i>Scoreboard</a>
                </li>
                <li><a class="dropdown-button" data-hover="true" data-beloworigin="true" data-activates="account"><i
                                class="material-icons left">supervisor_account</i>Account</a>
                </li>
                <li><a class="dropdown-button" data-hover="true" data-beloworigin="true" data-activates="addproblem"><i
                                class="material-icons left">mode_edit</i>Problems</a>
                </li>

                <li><a class="dropdown-button" data-hover="true" data-beloworigin="true" data-activates="search"><i
                                class="material-icons left">search</i>Search</a>
                </li>
            </ul>
        </div>
    </nav>
</div>

<ul id="account" class="dropdown-content blue white-text">
    <li><a href="index.php?action=show_account&username=<?php echo($_SESSION['user']['username']); ?>" class="white-text">Account</a></li>
    <li><a href="index.php?action=logout" class="white-text">Logout</a></li>
</ul>
<ul id="addproblem" class="dropdown-content blue white-text">
    <li><a href="index.php?action=show_add_challenge" class="white-text">Create Problem</a></li>
    <li><a href="index.php?action=show_unsolved_problems" class="white-text">Unsolved Problems</a></li>
    <li><a href="index.php?action=show_all_problems" class="white-text">All Problems</a></li>
</ul>
<ul id="search" class="dropdown-content blue white-text">
    <li><a href="index.php?action=show_problem_lookup" class="white-text">Problems</a></li>
    <li><a href="index.php?action=show_account_lookup" class="white-text">Users</a></li>
</ul>