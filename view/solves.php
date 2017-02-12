<?php
/**
 * Created by PhpStorm.
 * User: luklas
 * Date: 8/1/16
 * Time: 10:11 AM
 */

?>

<html>
<head>
<?php
include 'head.php';
?>
</head>
<body>
<?php
if (isset($_SESSION['user']['logged_in']))
    include 'navbarloggedin.php';
else
    include 'navbar.php';

echo '
<div class="row">
    <div class="col l12">
        <h5 class="center-align">' . $problem['problem_name'] . '</h5>
    </div>
</div>';

?>
    <div class="row">
        <div class="col l4 push-l4">

            <ul class="collection with-header">
                <li class="collection-header"><h5>All Solves</h5></li>
                <?php foreach ($solves as $solve) { ?>

                    <li class="collection-item truncate">
                        <span><b><u><a class="green-text" href="index.php?action=show_account&username=<?php echo(htmlspecialchars($solve['username']));?>"><?php echo(htmlspecialchars($solve['username'])); ?></a></u>&nbsp</b>solved<a class="green-text"><b>&nbsp<u><a class="green-text" href="index.php?action=find_problem_details&problem_id=<?php echo(htmlspecialchars($solve['problem_id'])); ?>"><?php echo(htmlspecialchars($solve['problem_name'])); ?></a></u></b>
                        <span class="secondary-content <?php if($solve['correct']) echo("green-text"); else echo("red-text"); ?>">
                                <?php echo time_elapsed_string($solve['submission_time']); ?>
                             </span>
                    </li>

                <?php } ?>
            </ul>

        </div>
    </div>
</body>
</html>