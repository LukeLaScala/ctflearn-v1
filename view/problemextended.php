<?php
/**
 * Created by PhpStorm.
 * User: luklas
 * Date: 11/2/2016
 * Time: 9:46 AM
 */

?>
<link rel="stylesheet" href="css/animate.css">

<html>
<head>
    <?php include 'head.php'?>
</head>
<body>
<?php
if(isset($_SESSION['user']['logged_in']))
    include 'navbarloggedin.php';
else
    include 'navbar.php';
?>


<?php
echo(get_submit_flag_alerts());
$problem = get_problem_from_id($problem_id);
?>

<div class="row animated fadeInUp">
    <div class="center-align">
        <p class="grey-text grey-lighten-3">Have some costs to offset |: </p>
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- gsfgdd -->
        <ins class="adsbygoogle"
             style="display:inline-block;width:728px;height:90px"
             data-ad-client="ca-pub-4379021343880694"
             data-ad-slot="8106565564"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    <div class="section"></div>
    </div>
    <div class="col l10 push-l1">
        <div class="card">
            <div class="card-content">
                <span class="center-align card-title truncate">
                    <h3><?php echo(htmlspecialchars(get_problem_from_id($problem['problem_id'])['problem_name'])); ?></h3>
                </span>
                <a class="grey-text text-darken-1 center-align card-title truncate" href="index.php?action=show_account&username=<?php echo(get_creator_from_id($problem['problem_id'])['username']); ?>">
                    <h5><?php echo(strtoupper("by " . htmlspecialchars(get_creator_from_id($problem['problem_id'])['username']))); ?></h5>
                </a><br>
                <p class="card-title" style="font-size: 20px; line-height: 1.4;">
                    <?php echo(get_desc_from_id($problem['problem_id'])['problem_description']); ?>
                </p>

                <?php if(!solved($problem['problem_id'], $_SESSION['user']['user_id'])){ ?>
                    <form action="index.php?action=check_submit_extended" method="post">
                        <div class="row">
                            <div class="input-field">
                                <input id="flag" name="flag" type="text" required>
                                <label for="flag">Flag</label>
                                <input type="hidden" name="problem_id" value="<?php echo($problem['problem_id']); ?>">
                            </div>
                        </div>
                        <button type="submit" class="waves-effect waves-light btn blue darken-3">Submit</button>
                    </form>
                <?php } else { ?>
                    <form action="index.php?action=check_submit_homepage" method="post">
                        <div class="row">
                            <div class="input-field">
                                <input disabled id="disabled" name="flag" type="text" required>
                                <label for="disabled">Flag</label>
                                <input type="hidden" name="problem_id" value="<?php echo($problem['problem_id']); ?>">
                            </div>
                        </div>
                        <button disabled type="submit" class="waves-effect waves-light btn green darken-3">Solved</button>
                    </form>
                <?php } ?>


                <h6>&nbsp</h6>
                <a href="index.php?action=solves&pid=<?php echo($problem['problem_id']); ?>"><?php echo(htmlspecialchars(get_num_solves($problem['problem_id']) . " solves")); ?></a>

            </div>
        </div>
    </div>

    <br>
    <br>

    <div class="row">
        <div class="col l3 push-l1">
            <h1>Comments</h1>
        </div>
        <div class="col l9">
            <form action="index.php?action=post_comment" method="post">
                <div class="row">
                    <div class="input-field col l8 push-l1">
                        <textarea id="comment" name="comment" class="materialize-textarea" minlength="10" maxlength="500"></textarea>
                        <label for="comment">Join The Discussion</label>
                        <input type="hidden" id="pid" name="pid" value="<?php echo($problem['problem_id']); ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col l8 push-l1">
                        <button type="submit" class="waves-effect waves-light btn blue darken-3">Post</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="row" style="padding-bottom: 10%;">
        <div class="col l10 push-l1">
            <ul class="collection">
            <?php  foreach (get_comments($problem['problem_id']) as $comment) { ?>
                <li class="collection-item">
                    <p><span>
                        <?php echo(htmlspecialchars($comment['comment'])); ?>
                    </span>
                    <span class="right"><?php echo("posted " . time_elapsed_string($comment['timestamp']));?> by <a href="index.php?action=show_account&username=<?php echo(htmlspecialchars($comment['username']));?>"><?php echo(htmlspecialchars($comment['username']));?></a><?php if($comment['user_id'] == $_SESSION['user']['user_id']) { ?><a href="index.php?action=delete_comment&cid=<?php echo($comment['cid']); ?>"><i class="right black-text material-icons">delete</i></a> <?php } ?>
 </span></p>
                </li>
            <?php } ?>
            </ul>
        </div>
    </div>
</body>
</html>