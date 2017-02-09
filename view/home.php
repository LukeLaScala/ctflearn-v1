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

        <div class="contain">
            <div class="row padding-top-30">
                <div class="col l7">
                    <a class="orange-text" href="index.php?action=show_unsolved_problems">Unsolved Problems</a>
                </div>
            </div>
            <div class="row">
               <div class="col l7">
                   <div class="card white">
                       <div class="card-content blue-text" id="main-problem">
                          <p><span class="card-title more-padding-bottom"><?php echo($problems[0]['problem_name']); ?></span><span class="right"><?php echo(get_username_html($problems[0]['username'])); ?></span></p>
                           <h6 class="blue-text"><?php echo(htmlspecialchars($problems[0]['category'])); ?></h6>
                           <div class="card-action">
                               <p class="wrap-word padding-top-30"><?php echo($problems[0]['problem_description']); ?></p>
                           </div>
                       </div>
                       <div class="card-action">
                           <a href="index.php?action=find_problem_details&problem_id=<?php echo($problems[0]['problem_id']); ?>">Solve now</a>
                       </div>
                   </div>
               </div>
               <div class="col l5">
                   <div class="card white">
                       <div class="card-content blue-text" id="main-problem">
                           <p><span class="card-title more-padding-bottom"><?php echo($problems[2]['problem_name']); ?></span><span class="right"><?php echo(get_username_html($problems[1]['username'])); ?></span></p>
                           <h6 class="blue-text"><?php echo(htmlspecialchars($problems[1]['category'])); ?></h6>
                           <div class="card-action">
                               <p class="wrap-word padding-top-30"><?php echo($problems[1]['problem_description']); ?></p>
                           </div>
                       </div>
                       <div class="card-action">
                           <a href="index.php?action=find_problem_details&problem_id=<?php echo($problems[1]['problem_id']); ?>">Solve now</a>
                       </div>
                   </div>
               </div>
           </div>

            <div class="section"></div>
            <div class="divider"></div>
            <div class="section"></div>
            <div class="section"></div>



            <div class="row">
                <div class="col l6">
                    <h4 class="inline">Posts from us</h4>
                </div>
                <div class="col l6">
                    <h4 class="inline">Posts from others</h4>
                    <a href="#add-post" class="right inline modal-trigger">Add a post</a>
                </div>
            </div>

            <div class="row">
                <div class="col l6 post border-bottom">
                    <?php foreach (get_admin_posts(3) as $post) { ?>
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


                <div class="col l6 post border-bottom">
                    <?php foreach (get_posts(3) as $post) { ?>
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

            <div class="row">
                <div class="col l6">
                    <a href="index.php?action=view_all_posts&type=ctflearn" class="right orange-text inline">Older posts</a>
                </div>
                <div class="col l6">
                    <a href="index.php?action=view_all_posts&type=other" class="right orange-text inline">Older posts</a>
                </div>
            </div>
        </div>

        <!-- Post Modal-->
        <div id="add-post" class="modal">
            <div class="modal-content">
                <h4>Add a post</h4>
                <form action="index.php?action=add_post" method="post">

                    <label for="description">News</label>
                    <textarea id="post" name="post" class="materialize-textarea" maxlength="400" required></textarea>

                    <button type="submit" class="waves-effect waves-light btn blue">Add Post</button>
                </form>
            </div>
        </div>
    </body>
</html>

