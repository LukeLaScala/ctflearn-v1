<?php
/**
 * Created by PhpStorm.
 * User: luklas
 * Date: 8/1/16
 * Time: 2:17 PM
 */

?>

<!-- Dropdown Structure
<ul id="dropdown1" class="dropdown-content">
    <li><a href="#!">one</a></li>
    <li><a href="#!">two</a></li>
    <li class="divider"></li>
    <li><a href="#!">three</a></li>
</ul>
-->
<!--
<div class="navbar-fixed">
    <nav>
        <div class="nav-wrapper blue darken-3 row">
            <div class="col l1">
                <a href="index.php" class="brand-logo">&nbsp; &nbsp; CTFLearn</a>
            </div>
            <ul class="right hide-on-med-and-down">
                <li><a href="index.php?action=show_login"><i class="material-icons left">supervisor_account</i>Log In</a></li>
                <li><a class="waves-effect waves-light btn-large blue darken-2" href="index.php?action=show_add_user">Sign Up</a></li>
                <li><a href="index.php?action=scoreboard"><i class="material-icons left">view_list</i>Scoreboard</a></li>
            </ul>
        </div>
    </nav>
</div>
-->
<div class="navbar-fixed">
    <nav>
        <div class="nav-wrapper blue darken-3 row">
            <div class="col l1">
                <a href="index.php" class="brand-logo">&nbsp; &nbsp; CTFLearn</a>
            </div>
            <ul class="right hide-on-med-and-down">
                <div class="row">
                    <form class="col s12">
                        <div class="row">
                            <div class="input-field col s5 pull-s1">
                                <div class="input-field">
                                    <input value="Username" id="username" type="search" name="username" required autocomplete="off">
                                    <label for="username"><i class="material-icons">supervisor_account</i></label>

                                </div>
                            </div>
                            <div class="input-field col s5 pull-s1">
                                <div class="input-field">
                                    <input value="Password" id="password" type="search" type="password" required>

                                    <label for="password"><i class="material-icons">lock</i></label>
                                </div>
                            </div>
                            <div class="col s1 pull-s1">
                                <li><a class="waves-effect waves-light btn blue darken-2">Login</a></li>
                            </div>
                        </div>
                    </form>
                </div>
            </ul>
        </div>
    </nav>
</div>
