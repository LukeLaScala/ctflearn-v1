<?php
/**
 * Created by PhpStorm.
 * User: hirok
 * Date: 9/21/2016
 * Time: 10:26 AM
 */
?>
<link rel="stylesheet" href="css/animate.css">
<style>
    .card:hover {
        cursor: pointer;
    }
</style>
<div class="row">
    <div class="col s12 ">
        <div class="card grey lighten-4" onclick="window.parent.location.href='index.php?action=find_problem_details&problem_id=<?php echo($problem['problem_id']); ?>'">
            <div class="card-content">
                <?php if (solved($problem['problem_id'], $_SESSION['user']['user_id'])) { ?>
                    <p><a href="index.php?action=find_problem_details&problem_id=<?php echo($problem['problem_id']); ?>" class="material-icons black-text text-darken-3 right">done</a></p>
                <?php } ?>
                <a class="card-title black-text truncate"
                   href="index.php?action=find_problem_details&problem_id=<?php echo($problem['problem_id']); ?>">
                    <?php echo(htmlspecialchars(get_problem_from_id($problem['problem_id'])['problem_name'])); ?>
                </a>

                <a class="black-text">
                    <?php echo(htmlspecialchars(get_problem_type_from_id($problem['problem_id'])['category'])); ?>
                </a>
                <br>
                <a class="black-text"
                   href="index.php?action=solves&pid=<?php echo($problem['problem_id']); ?>"><?php echo(get_num_solves($problem['problem_id']) . " solves"); ?>
                </a>
                <br>
                <br>

                <p class="truncate" style="cursor: hand;" onclick="window.parent.parent.location.href='index.php?action=find_problem_details&problem_id=<?php echo($problem['problem_id']); ?>'">
                    <?php
                    echo(htmlspecialchars(get_desc_from_id($problem['problem_id'])['problem_description']));
                    ?>
                </p>
            </div>
            <div class="row card-action">
                <?php if (!solved($problem['problem_id'], $_SESSION['user']['user_id'])) { ?>
                    <a class="col l4 waves-effect waves-light btn blue darken-3" href="index.php?action=find_problem_details&problem_id=<?php echo($problem['problem_id']); ?>">Solve</a>
                <?php } else { ?>
                    <a disabled class="col l4 waves-effect waves-light btn green darken-3">Solved</a>
                <?php } ?>
                <a class="col l7 right-align truncate grey-text darken-7"
                   href="index.php?action=show_account&username=<?php echo(htmlspecialchars(get_creator_from_id($problem['problem_id'])['username'])); ?>">
                    by
                    <?php echo(htmlspecialchars(get_creator_from_id($problem['problem_id'])['username'])); ?>
                </a>
            </div>
        </div>
    </div>
</div>
