<?php
/**
 * Created by PhpStorm.
 * User: luklas
 * Date: 2/5/17
 * Time: 7:35 PM
 */

?>

<html>
<head>
    <?php include 'head.php' ?>
</head>
<body>
<?php if (isset($_SESSION['user']['logged_in']))
include 'navbarloggedin.php';
else
include 'navbar.php';
date_default_timezone_set(date_default_timezone_get());

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
?>
<div class="row" style="padding-left: 5%;">
<div class="col l6 m6 s12 push-l3 push-m3">
        <h4>All News</h4>

        <?php foreach (get_all_news() as $news) { ?>
    <div class="card-panel white">
        <span class="blue-text"><?php echo $news['news']; ?></span>
        <br>
        <br>
        <span class="blue-text"><?php echo(time_elapsed_string($news['timestamp'])); ?></span>
    </div>
<?php } ?>
</div>
</div>
</body>
</html>


