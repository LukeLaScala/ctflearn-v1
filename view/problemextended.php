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
echo(get_alerts());
$problem = get_problem_from_id($problem_id);
?>
<style>
    .padding-top-30 {
        padding-top: 30px;
    }
</style>
<div class="row">
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
                    <h5><?php echo(htmlspecialchars(get_problem_from_id($problem['problem_id'])['problem_name'])); ?></h5>
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

</div>


<div class="row container padding-top-30">
    <div class="col l12">
        <h5 style="display: inline"><?php echo(get_num_comments($problem['problem_id'])); ?> Comments</h5> <a href="#reply" class="modal-trigger right orange-text">Add a comment</a>
        <div class="divider"></div>
    </div>
</div>

<div class="row">
    <div class="col l10 push-l1">
        <?php $i = 0; foreach (get_comments($problem['problem_id']) as $comment) { $i += 1 ?>
            <div class="card white">
                <div class="card-content black-text">
                    <div class="row">
                        <div class="col l10">
                            <p class="black-text"><?php echo($comment['comment']); ?></p>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <p><span><a href="#reply<?php echo $i ?>" class="modal-trigger material-reply "><i class="left material-icons">reply</i> Reply</a> <?php echo(get_username_html($comment['username'])); ?></span>
                        <span class="right"><?php echo(time_elapsed_string($comment['timestamp'])); ?></span>
                        <?php if(($_SESSION['user']['user_id'] == $comment['user_id']) || $_SESSION['user']['admin']) {?>
                            <a class="right material-reply" href="index.php?action=delete_comment&cid=<?php echo($comment['cid']); ?>"><i class="material-icons">delete</i></a>
                        <?php } ?>
                    </p>
                </div>
            </div>
            <!-- Subreplies -->

            <div class="row">
                <div class="col l10 push-l2">
                    <?php foreach (get_comment_subreplies($comment['cid']) as $subcomment) { ?>
                        <div class="card white">
                            <div class="card-content black-text">
                                <div class="row">
                                    <div class="col l10">
                                        <p class="black-text"><?php echo($subcomment['comment']); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action">
                                <p><span><?php echo(get_username_html($subcomment['username'])); ?></span><span class="right"><?php echo(time_elapsed_string($subcomment['timestamp'])); ?>

                                        <?php if(($_SESSION['user']['user_id'] == $subcomment['user_id']) || $_SESSION['user']['admin']) {?>
                                            <a class="right material-reply" href="index.php?action=delete_comment&cid=<?php echo($subcomment['cid']); ?>"><i class="material-icons">delete</i></a>
                                        <?php } ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

        <?php } ?>
    </div>
</div>

<div id="reply" class="modal">
    <div class="modal-content">
        <h4>Comment</h4>
        <form action="index.php?action=add_comment" method="post">
            <textarea id="comment" name="comment" class="materialize-textarea" maxlength="400" required></textarea>
            <input type="hidden" name="pid" value="<?php echo($problem['problem_id']); ?>">
            <button type="submit" class="waves-effect waves-light btn blue">Add Comment</button>
        </form>
    </div>
</div>

<?php $ii = 0; foreach (get_comments($problem['problem_id']) as $comment) { $ii += 1 ?>
    <div id="reply<?php echo($ii); ?>" class="modal">
        <div class="modal-content">
            <h4>Reply to comment</h4>
            <form action="index.php?action=add_comment" method="post">
                <textarea id="comment" name="comment" class="materialize-textarea" maxlength="400" required></textarea>
                <input type="hidden" name="pid" value="<?php echo($problem['problem_id']); ?>">
                <input type="hidden" name="comment_parent" value="<?php echo($comment['cid']); ?>">
                <button type="submit" class="waves-effect waves-light btn blue">Add Comment</button>
            </form>
        </div>
    </div>
<?php } ?>

</body>
</html>