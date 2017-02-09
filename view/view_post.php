<html>
<head>
    <?php include 'head.php'?>
    <style>
        .wrap-word { word-wrap: break-word; }

        #main-problem {
            min-height: 45%;
        }

        .padding-top-30 {
            padding-top: 30px;
        }

        .contain {
            width: 95%;
            margin: auto;
        }

        .inline {
            display: inline;
        }

        /*.border-bottom {
            border-bottom: 2px solid black;
            border-collapse: collapse;
        } */
    </style>
</head>
<body>
<?php include 'navbarloggedin.php' ?>
<?php echo(get_alerts()); ?>

        <div class="contain padding-top-30">
            <div class="row">
                <div class="col l12">
                    <h3>Conversation</h3>
                </div>
            </div>
            <div class="row">
                <div class="card white">
                    <div class="card-content black-text">
                        <p class="black-text"><?php echo($post['post']); ?></p>
                    </div>
                    <div class="card-action">
                        <p><span><?php echo(get_username_html($post['username'])); ?></span><span class="right"><?php echo(time_elapsed_string($post['timestamp'])); ?></span></p>
                    </div>
                </div>
            </div>
            <div class="row padding-top-30">
                <div class="l12">
                    <h5><?php echo(get_num_replies($post['post_id'])); ?> Comments <a href="#reply" class="modal-trigger right orange-text">Add a comment</a></h5>
                    <div class="divider"></div>
                </div>
            </div>
            <div class="row">
                <div class="col l10 push-l2">
                    <?php $i = 0; foreach (get_post_replies($post['post_id']) as $reply) { $i += 1 ?>
                    <div class="card white">
                        <div class="card-content black-text">
                            <div class="row">
                                <div class="col l10">
                                    <p class="black-text"><?php echo($reply['reply']); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-action">
                            <p><span><a href="#reply<?php echo $i ?>" class="modal-trigger"><i class="grey-text left material-icons">replay</i></a> <?php echo(get_username_html($reply['username'])); ?></span><span class="right"><?php echo(time_elapsed_string($reply['timestamp'])); ?></span></p>
                        </div>
                    </div>
                        <!-- Subreplies -->

                    <div class="row">
                        <div class="col l10 push-l2">
                            <?php foreach (get_post_subreplies($reply['reply_id']) as $subreply) { ?>
                            <div class="card white">
                                <div class="card-content black-text">
                                    <div class="row">
                                        <div class="col l10">
                                            <p class="black-text"><?php echo($subreply['reply']); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-action">
                                    <p><span><?php echo(get_username_html($subreply['username'])); ?></span><span class="right"><?php echo(time_elapsed_string($subreply['timestamp'])); ?></span></p>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>

                    <?php } ?>
                </div>
            </div>
        </div>


<!-- Reply Parent Modal-->
<div id="reply" class="modal">
    <div class="modal-content">
        <h4>Reply</h4>
        <form action="index.php?action=reply" method="post">
            <textarea id="reply" name="reply" class="materialize-textarea" maxlength="400" required></textarea>
            <input type="hidden" name="post_id" value="<?php echo($post['post_id']); ?>">
            <button type="submit" class="waves-effect waves-light btn blue">Add Reply</button>
        </form>
    </div>
</div>

<?php $j = 0; foreach (get_post_replies($post['post_id']) as $reply) { $j += 1 ?>

<!-- Reply Modal-->
<div id="reply<?php echo($j); ?>" class="modal">
    <div class="modal-content">
        <h4>Reply</h4>
        <form action="index.php?action=reply" method="post">
            <textarea id="reply" name="reply" class="materialize-textarea" maxlength="400" required></textarea>
            <input type="hidden" name="parent_post_id" value="<?php echo($post['post_id']); ?>">
            <input type="hidden" name="reply_parent" value="<?php echo($reply['reply_id']); ?>">
            <button type="submit" class="waves-effect waves-light btn blue">Add Reply</button>
        </form>
    </div>
</div>

<?php } ?>
</body>
</html>

