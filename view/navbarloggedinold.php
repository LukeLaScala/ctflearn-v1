<?php
/**
 * Created by PhpStorm.
 * User: luklas
 * Date: 8/1/16
 * Time: 2:17 PM
 */

?>

<!-- Dropdown Structure -->
<ul id="dropdown1" class="dropdown-content orange white-text">
    <li><a href="index.php?action=show_add_challenge" class="white-text">Create Problem</a></li>
    <li><a href="index.php?action=show_unsolved_problems" class="white-text">Unsolved Problems</a></li>
    <!-- <li><a href="index.php?action=show_unsolved_problems" class="white-text">Unsolved Problems</a></li> -->

</ul>

<ul id="dropdown2" class="dropdown-content orange white-text">
    <li><a href="index.php?action=show_account&username=<?php echo($_SESSION['user']['username']); ?>"
           class="white-text">Account</a></li>
    <!-- <li><a href="index.php?action=show_unsolved_problems" class="white-text">Unsolved Problems</a></li> -->
    <li><a href="index.php?action=logout" class="white-text">Logout</a></li>
</ul>

<ul id="dropdown3" class="dropdown-content orange white-text">
    <li><a href="index.php?action=show_account_lookup" class="white-text">Users</a></li>
</ul>


<div class="navbar-fixed">
    <nav>
        <div class="nav-wrapper orange row">
            <div class="col l1">
                <a href="index.php" class="brand-logo">&nbsp; &nbsp; CTFLearn</a>
            </div>
            <div class="col l4 push-l3 center-align">
                <form action="index.php?" method="get" class="center-align">
                    <div class="input-field orange white-text center-align">
                        <input class="orange-text center-align" id="search" name="problem_name"
                               placeholder="Search for problems" type="search" required>
                        <input type="hidden" value="lookup_problem" name="action">
                        <label for="search"><i class="center-align material-icons">search</i></label>
                        <i class="material-icons center-align">close</i>
                    </div>
                </form>
            </div>
            <div class="col l4 right">
                <div class="right">
                    <ul class="right hide-on-med-and-down">
                        <li><a class="dropdown-button" href="#!" data-activates="dropdown2"><i
                                    class="material-icons yellow-text left">supervisor_account</i></a></li>
                        <!-- Dropdown Trigger -->
                        <li><a class="dropdown-button" href="#!" data-activates="dropdown1"><i
                                    class="material-icons left">mode_edit</i></a></li>
                        <li><a href="index.php?action=scoreboard"><i class="material-icons left">view_list</i></a></li>
                        <li><a class="dropdown-button" href="#!" data-activates="dropdown3"><i
                                    class="material-icons left">search</i></a></li>
                        <!--<li><a href="index.php?action=help"><i class="material-icons left">help_outline</i></a></li>-->
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>