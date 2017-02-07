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
<link rel="stylesheet" href="css/animate.css">

<style type="text/css">
    ::-webkit-scrollbar {
        display: none;
    }
</style>

<div class="row">
    <div class="col l8 push-l2">
        <table class="highlight">
            <thead>
            <tr>
                <th data-field="price">Rank</th>
                <th data-field="id">Username</th>
                <th data-field="price">Points</th>

            </tr>
            </thead>
                <tbody>
            <?php for ($i = 0; $i<count($names_reversed); $i++){?>

                <tr class="animated fadeInUp">
                    <td><?php echo($i + 1 . ""); ?></td>
                    <td><?php echo("<a class=\"orange-text\" href=\"index.php?action=show_account&username=" . htmlspecialchars($names_reversed[$i]) . "\">" . htmlspecialchars($names_reversed[$i]) . "</a>" ); ?></td>
                    <td>
                        <?php if($scores_reversed[$i] == 0){
                            echo(0);
                        } else {
                            echo(htmlspecialchars($scores_reversed[$i]));
                        } ?>
                    </td>
                </tr>

        <?php }?>
                </tbody>
        </table>
    </div>
</div>

</body>


</html>


