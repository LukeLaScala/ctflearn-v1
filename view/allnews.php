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
        <?php foreach ($posts as $post) { ?>
            <div class="card white">
                <div class="card-content black-text">
                    <p class="black-text"><?php echo($post['post']); ?></p>
                </div>
                <div class="card-action">
                    <p><span><?php echo(get_username_html($post['username'])); ?></span><span class="right"><?php echo(time_elapsed_string($post['timestamp'])); ?> – &nbsp<a href="index.php?action=view_post&post_id=<?php echo($post['post_id']); ?>" class="right orange-text inline"><?php echo(get_num_replies($post['post_id'])); ?> Comments</a></span></p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
</body>
</html>

