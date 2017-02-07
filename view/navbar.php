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
        <div class="nav-wrapper blue darken-3 row">
            <div class="col l1">
                <a href="index.php" class="brand-logo">&nbsp; &nbsp; CTFLearn</a>
            </div>
            <ul class="right hide-on-med-and-down">
                <div class="row">
                    <form class="col s12" action="index.php?action=login" method="post">
                        <div class="row">
                            <div class="input-field col s5 pull-s1" style="opacity: 0.7;" id="uname">
                                <input name="username" id="password" type="text" placeholder="Username/Email..." autofocus>
                            </div>

                            <div class="input-field col s5 pull-s1" style="opacity: 0.7;">
                                <input name="password" id="password" type="password" placeholder="Password...">
                            </div>

                            <div class="col s1 pull-s1">
                                <li><button type="submit" class="waves-effect waves-light btn blue darken-2">Login</button></li>
                            </div>
                        </div>
                    </form>
                </div>
            </ul>
        </div>
    </nav>
</div>
