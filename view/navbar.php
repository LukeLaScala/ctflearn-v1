<?php
    /**
     * Created by PhpStorm.
     * User: luklas
     * Date: 8/1/16
     * Time: 2:17 PM
     */
?>

<div class="navbar-fixed">
    <nav>
        <div class="nav-wrapper blue">
            <a href="index.php" style="padding-left: 10px;" class="brand-logo">CTFLearn</a>
            <ul class="right hide-on-small-only">
                <li><a href="index.php?action=show_add_user">Register</a></li>
                <li><a href="index.php?action=show_login">Login</a></li>
                <li><a class="dropdown-button" data-hover="true" data-beloworigin="true" data-activates="problems-dropdown">Problems</a></li>
                <li><a href="index.php?action=global_activity">Activity</a></li>
                <li><a href="index.php?action=scoreboard">Scoreboard</a></li>
            </ul>
        </div>
    </nav>
</div>

<ul id="problems-dropdown" class="dropdown-content blue white-text">
    <li><a href="index.php?action=show_add_challenge" class="white-text">Create Problem</a></li>
    <li><a href="index.php?action=show_unsolved_problems" class="white-text">Unsolved Problems</a></li>
    <li><a href="index.php?action=show_all_problems" class="white-text">All Problems</a></li>
</ul>