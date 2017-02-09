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
                   <div class="card white">
                       <div class="card-content blue-text" id="main-problem">
                          <p><span class="card-title more-padding-bottom">Hextraordinary</span><span class="right">By Intelagent</span></p>
                           <h6 class="blue-text">Forensics</h6>
                           <div class="card-action">
                               <p class="wrap-word padding-top-30">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                           </div>
                       </div>
                       <div class="card-action">
                           <a href="#">Solve now</a>
                       </div>
                   </div>
               </div>
               <div class="col l5">
                   <div class="card white" style="flex-grow: 1;">
                       <div class="card-content blue-text" id="main-problem">
                           <p><span class="card-title more-padding-bottom">Hextraordinary</span><span class="right">By Intelagent</span></p>
                           <h6 class="blue-text">Forensics</h6>
                           <div class="card-action">
                               <p class="wrap-word padding-top-30">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                           </div>
                       </div>
                       <div class="card-action">
                           <a href="#">Solve now</a>
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
                    <a href="#add-comment" class="right inline modal-trigger">Add a post</a>
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
                                <p><span><?php echo(get_username_html($post['username'])); ?></span><span class="right"><?php echo(time_elapsed_string($post['timestamp'])); ?> – &nbsp<a href="index.php?action=view_post&post_id=<?php echo($post['post_id']); ?>" class="right orange-text inline">32 Comments</a></span></p>
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
                            <p><span><?php echo(get_username_html($post['username'])); ?></span><span class="right"><?php echo(time_elapsed_string($post['timestamp'])); ?> – &nbsp<a href="index.php?action=view_post&post_id=<?php echo($post['post_id']); ?>" class="right orange-text inline">32 Comments</a></span></p>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>

            <div class="row">
                <div class="col l6">
                    <a href="#" class="right inline">Older posts</a>
                </div>
                <div class="col l6">
                    <a href="#" class="right inline">Older posts</a>
                </div>
            </div>
        </div>

        <!-- Post Modal-->
        <div id="add-comment" class="modal">
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

