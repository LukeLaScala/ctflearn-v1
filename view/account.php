<?php
/**
 * Created by PhpStorm.
 * User: luklas
 * Date: 7/31/16
 * Time: 10:36 PM
 */

?>
<style type="text/css">
    ::-webkit-scrollbar {
        display: none;
    }
</style>

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
echo(get_add_group_alerts());
echo(get_add_challenge_alerts());
echo(get_follow_alerts());
echo(get_upload_alerts());
echo(get_join_group_alerts());
echo(get_edit_alerts());

?>
<div class="row valign">
    <div class="col l12">
        <div class="card">
            <div class="card-image waves-effect waves-light" style="max-height: 35%; width: 100%;">
                <img style="width: 100%; height: auto; transform: translateY(-25%); " src="<?php echo("uploads/" . $user['profile_picture_path']); ?>" <?php if($_SESSION['user']['user_id'] == $user['user_id']) echo("onclick=\"$('#modal1').openModal();\"");?>>
            </div>

            <div class="card-content">
                <div class="row">
                    <div class="col l2">
                        <span class="card-title grey-text text-darken-4"> <?php echo(htmlspecialchars($user['username']))?></span><br>
                        <?php if($user['user_id'] != $_SESSION['user']['user_id']){
                            if(!already_following($_SESSION['user']['user_id'], $user['user_id'])){ ?>
                                <a class="white-text" href="index.php?action=follow&friend_id=<?php echo($user['user_id']); ?>"><button class="waves-effect waves-light btn blue darken-2">Follow</button></a> 
                            <?php }
                            else { ?>
                                <a class="white-text" href="index.php?action=unfollow&friend_id=<?php echo($user['user_id']); ?>"><button type="submit" class="waves-effect waves-light btn blue darken-2">Unfollow</button> </a>
                            <?php }
                        }
                        ?>
                    </div>

                    <div class="col l2">
                        <span class="card-title grey-text text-darken-4 center-align"><a style="color: inherit;" href="index.php?action=show_all_followers&username=<?php echo($user['username']); ?>">Followers</a></span><br><?php echo(num_followers($user['user_id'])); ?>
                    </div>

                    <div class="col l2">
                        <span class="card-title grey-text text-darken-4 center-align"><a style="color: inherit;" href="index.php?action=show_all_following&username=<?php echo($user['username']); ?>">Following</a></span><br><?php echo(num_following($user['user_id'])); ?>
                    </div>

                    <div class="col l3">
                        <span class="card-title grey-text text-darken-4 center-align"><a style="color: inherit;" href="index.php?action=show_all_problems_solved&username=<?php echo($user['username']); ?>">Problems Solved</a></span><br><?php echo(get_num_solved_problems($user['user_id'])); ?>
                    </div>

                    <div class="col l3">
                        <span class="card-title grey-text text-darken-4 center-align"><a style="color: inherit;" href="index.php?action=show_all_problems_added&username=<?php echo($user['username']); ?>">Problems Added</a></span><br><?php echo(get_num_problems_contributed($user['user_id'])); ?>
                    </div>

                </div>
        </div>
    </div>
</div>

    <div class="col l10 push-l1">

        <ul class="collection with-header">
            <li class="collection-header"><h5>Recent Activity</h5></li>
            <?php foreach ($recent_submissions as $submission) { ?>

                <li class="collection-item truncate">
                    <div>
                        <?php $time = ($submission['submission_time']); ?>
                        <span class="<?php if($submission['correct']) echo("green-text"); else echo("red-text"); ?>"><b><u><a class="<?php if($submission['correct']) echo("green-text"); else echo("red-text"); ?>" href="index.php?action=show_account&username=<?php echo(htmlspecialchars($submission['username']));?>"><?php echo(htmlspecialchars($submission['username'])); ?></a></u></b> <?php if($submission['correct']) echo("solved"); else echo("attempted"); ?>&nbsp<a class="<?php if($submission['correct']) echo("green-text"); else echo("red-text"); ?>"><b><u><a class="<?php if($submission['correct']) echo("green-text"); else echo("red-text"); ?>" href="index.php?action=find_problem_details&problem_id=<?php echo(htmlspecialchars($submission['problem_id'])); ?>"><?php echo(htmlspecialchars($submission['problem_name'])); ?></a></u></b>
                                </span>
                            <span class="secondary-content <?php if($submission['correct']) echo("green-text"); else echo("red-text"); ?>">
                                <?php echo time_elapsed_string($time); ?>
                             </span>
                    </div>
                </li>

            <?php } ?>
        </ul>

    </div>

<!-- Modal Structure -->
<div id="modal1" class="modal modal-fixed-footer">
    <div class="modal-content">
        Update your profile picture
        <form action="index.php?action=upload" method="post" enctype="multipart/form-data">
            <div class="file-field input-field">
                <div class="btn blue darken-2">
                    <span>Picture</span>
                    <input type="file" name="fileToUpload">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                </div>
            </div>

            <input class="btn right blue darken-2" type="submit">

        </form>
    </div>

</div>

<?php /*
if(isset($_SESSION['user']['logged_in']))
    include 'footerloggedin.php';
else
    include 'navbar.php';
*/ ?>

</body>

</html>
