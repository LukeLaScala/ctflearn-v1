<?php
/**
 * Created by PhpStorm.
 * User: hirok
 * Date: 9/21/2016
 * Time: 12:12 AM
 */
?>
<style type="text/css">
    ::-webkit-scrollbar {
        display: none;
    }
</style>

<!--
<div class="row">
        <div class="col l10 offset-l1">
            <div class="section">
                <h3>Featured Problem</h3>
                <p><h5>This week's featured problem.</h5>
                <div class="col l12"> -->
                    <?php // include 'featuredproblem.php'; ?>
                   <!-- <a class=" right-align blue-text darken-3" href="moreview"><h5>View Previously Featured Problems</h5></a>
                </div>

            </div>
        </div>
</div>
 -->

    <div class="row">
        <div class="section col l10 offset-l1">
            <h3>Popular Problems</h3>
            <?php foreach(get_problems_by_solve_count() as $problem){ ?>
            <div class="col s4 animated fadeIn">
                <?php
                include 'problem.php';
                ?>
            </div>
            <?php } ?>
            <!-- <a class="right-align blue-text darken-3" href="moreview"><h5>View More</h5></a> -->

        </div>
    </div>

    <div class="divider"></div>
    <div class="row">
        <div class="section col l10 offset-l1">
            <h3>Newest Problems</h3>
            <?php foreach(get_recently_added_problems() as $problem){ ?>
                <div class="col s4 animated fadeIn">
                    <?php
                    include 'problem.php';
                    ?>
                </div>
            <?php } ?>
            <!-- <a class="right-align blue-text darken-3" href="moreview"><h5>View More</h5></a> -->

        </div>
    </div>

    <div class="divider"></div>
    <div class="row">
        <div class="section col l10 offset-l1">
            <h3>Random Problems</h3>
            <?php foreach(get_random_problems() as $problem){ ?>
                <div class="col s4 animated fadeIn">
                    <?php
                    include 'problem.php';
                    ?>
                </div>
            <?php } ?>
            <!-- <a class="right-align blue-text darken-3" href="moreview"><h5>View More</h5></a> -->

        </div>
    </div>