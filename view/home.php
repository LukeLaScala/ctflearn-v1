<?php date_default_timezone_set(date_default_timezone_get());

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
if (!isset($_SESSION['needsmodalhome'])) {

}

if ((count(get_solved_problems($_SESSION['user']['user_id'])) < 1) && isset($_SESSION['needsmodalhome']) && $_SESSION['needsmodalhome'] == 1) {
    $needsmodal = true;
    unset($_SESSION['needsmodalhome']);
} ?>
<html>
<head>
    <?php $pid = get_problem_by_name("Practice Flag")['problem_id']; ?>


    <?php include 'head.php' ?>
    <div id="modal1" class="modal">
        <div class="modal-content">
            <h5>Hello, we see you have just signed up!</h5>
            <p>How about starting with <a href="index.php?action=find_problem_details&problem_id=<?php echo($pid); ?>">this</a> problem?</p>
            <p>You can join us on slack, <a href="index.php?action=slack">here</a>.</p>
            <p>
                Or you can add your own problem <a href="index.php?action=show_add_challenge">here</a>.
            <p>
        </div>

    </div>
    <?php if(isset($needsmodal) and $needsmodal)
        echo('<script>$(\'#modal1\').openModal();</script>');
    ?>
</head>


<body>
<?php
if (isset($_SESSION['user']['logged_in']))
    include 'navbarloggedin.php';
else
    include 'navbar.php';
echo(get_registration_alerts());
echo(get_login_alerts());
echo(get_submit_flag_alerts());
?>

<div class="row" style="padding-left: 5%;">

    <div class="col l6 m6 s12">
        <h4>&nbsp;Recent News</h4>
        <?php foreach (get_recent_news() as $news) { ?>
            <div class="card-panel white">
                <span class="blue-text"><?php echo $news['news']; ?></span>
                <br>
                <br>
                <span class="blue-text"><?php echo(time_elapsed_string($news['timestamp'])); ?></span>
            </div>
        <?php } ?>
        <a href="index.php?action=all_news">View Older News</a>
    </div>
    <div class="col l16 m6 s12">
        <h4>&nbspNew Users</h4>
        <div class="card-panel white">
            <?php foreach (get_recent_users() as $user) { ?>
                <p><span><a href="index.php?action=show_account&username=<?php echo($user['username']); ?>"><?php echo($user['username']); ?></a></span><span class="right"><?php echo(time_elapsed_string($user['account_created'])); ?></span></p>
            <?php } ?>
        </div>
        <div class="card-panel white">
            <p><span>Total Users: </span><span class="right"><?php echo(count(get_all_users())); ?></span></p>
            <p><span>Total Submissions: </span><span class="right"><?php echo(get_total_submissions()); ?></span></p>

        </div>
    </div>
</div>



</body>


<?php include 'footer.php';?>
</html>
