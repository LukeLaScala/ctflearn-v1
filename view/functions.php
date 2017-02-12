<?php

/**
 * Created by PhpStorm.
 * User: luklas
 * Date: 8/1/16
 * Time: 3:31 PM
 */

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

function get_username_html($username){
    return '<a class="orange-text" href="index.php?action=show_account&username=' . $username . '">' . $username . '</a>';
}

function get_registration_alerts(){
    if(isset($_SESSION['registration'])) {
        $alerts = $_SESSION['registration'];
        $to_ret = "<scr" . "ipt>Materialize.toast('$alerts', 2000);</script>";
        unset($_SESSION['registration']);
        return $to_ret;
    }

    else
        return "";
}

function navbar(){
    if(isset($_SESSION['user'])){
        include 'navbarloggedin.php';
    } else {
        include 'navbar.php';
    }
}

function is_leader_of_group($user_id, $group_id){
    return get_group_by_id($group_id)['user_id'] == $user_id;
}

function get_login_alerts(){
    if(isset($_SESSION['login'])) {
        $alerts = $_SESSION['login'];
        $to_ret = "<scr" . "ipt>Materialize.toast('$alerts', 2000);</script>";
        unset($_SESSION['login']);
        return $to_ret;
    }
    else
        return "";
}

function get_alerts(){
    if(isset($_SESSION['alerts'])) {
        $alerts = $_SESSION['alerts'];
        $to_ret = "<scr" . "ipt>Materialize.toast('$alerts', 2000);</script>";
        unset($_SESSION['alerts']);
        return $to_ret;
    }
    else
        return "";
}


function get_require_login_alerts(){
    if(isset($_SESSION['require_login'])) {
        $alerts = $_SESSION['require_login'];
        $to_ret = "<scr" . "ipt>Materialize.toast('$alerts', 2000);</script>";
        unset($_SESSION['require_login']);
        return $to_ret;
    }

    else
        return "";
}

function get_add_challenge_alerts(){
    if(isset($_SESSION['add_challenge'])) {
        $alerts = $_SESSION['add_challenge'];
        $to_ret = "<scr" . "ipt>Materialize.toast('$alerts', 2000);</script>";
        unset($_SESSION['add_challenge']);
        return $to_ret;
    }

    else
        return "";
}

function get_submit_flag_alerts(){
    if(isset($_SESSION['submit_flag'])) {
        $alerts = $_SESSION['submit_flag'];
        $to_ret = "<scr" . "ipt>Materialize.toast('$alerts', 2000);</script>";
        unset($_SESSION['submit_flag']);
        return $to_ret;
    }

    else
        return "";
}

function get_lookup_user_alerts(){
    if(isset($_SESSION['lookup_user'])) {
        $alerts = $_SESSION['lookup_user'];
        $to_ret = "<scr" . "ipt>Materialize.toast('$alerts', 2000);</script>";
        unset($_SESSION['lookup_user']);
        return $to_ret;
    }

    else
        return "";
}

function get_upload_alerts(){
    if(isset($_SESSION['upload'])) {
        $alerts = $_SESSION['upload'];
        $to_ret = "<scr" . "ipt>Materialize.toast('$alerts', 2000);</script>";
        unset($_SESSION['upload']);
        return $to_ret;
    }

    else
        return "";
}

function get_follow_alerts(){
    if(isset($_SESSION['follow'])) {
        $alerts = $_SESSION['follow'];
        $to_ret = "<scr" . "ipt>Materialize.toast('$alerts', 2000);</script>";
        unset($_SESSION['follow']);
        return $to_ret;
    }

    else
        return "";
}

function require_login() {
    if(!isset($_SESSION['user']['logged_in'])) {
        $_SESSION['alerts'] = "You need to login! ";
        header("Location: index.php");
    }
    return;
}

function debug_to_console( $data ) {

    if ( is_array( $data ) )
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

    echo $output;
}

function get_recently_solved_problems_html($problems, $username){
    $html = "";

    $first = true;
    $second = false;

    foreach($problems as $problem){
        if($first){
                $html .= '<div class="col l8">
                    <p class="white-text tooltipped" data-position="top" data-delay="50" data-tooltip="' . $problem['submission_time'] . ' ET"><u><a class="white-text" href="index.php?action=lookup_problem&problem_name=' . $problem['problem_name'] . '">' . $problem['problem_name'] . "</a></u>" . " - " . $problem['difficulty'] . "pts" . '</p>
                </div><br>';
            $second = true;
        }

        else if($second){
            $html .= '<div class="col l4 white-text">
                        <a href="index.php?action=show_all_problems_solved&username=' . $username . '" class="white-text">View All</a>
                    </div>
                      <div class="col l8">
                    <p class="white-text tooltipped" data-position="top" data-delay="50" data-tooltip="' . $problem['submission_time'] . ' ET"><u><a class="white-text" href="index.php?action=lookup_problem&problem_name=' . $problem['problem_name'] . '">' . $problem['problem_name'] . "</a></u>" . " - " . $problem['difficulty'] . "pts" . '</p>
                </div>';
            $second = false;
        }

        else {
            $html .= '<div class="col l8 push-l4">
                    <p class="white-text tooltipped" data-position="top" data-delay="50" data-tooltip="' . $problem['submission_time'] . ' ET"><u><a class="white-text" href="index.php?action=lookup_problem&problem_name=' . $problem['problem_name'] . '">' . $problem['problem_name'] . "</a></u>" . " - " . $problem['difficulty'] . "pts" . '</p>
                </div>';
        }

        $first = false;

    }

    return $html;
}

function get_following_html($users){
    $html = "";

    $first = true;
    $second = false;

    foreach($users as $user){
        if($first){
            $html .= '<div class="col l6 push-l2">
                    <p class="white-text tooltipped" data-position="top" data-delay="50" data-tooltip="' . $user['timestamp'] . ' ET"><u><a class="white-text" href="index.php?action=show_account&username=' . $user['username'] . '"> ' . $user['username'] . '</a></u></p>
                      </div>';
            $second = true;
        }

        else if($second){
            $html .= '<div class="col l4 white-text">
                        <a href="index.php?action=show_all_following&username=' . $_GET['username'] . '" class="white-text">View All</a>
                    </div>
                      <div class="col l6 push-l2">
                    <p class="white-text tooltipped" data-position="top" data-delay="50" data-tooltip="' . $user['timestamp'] . ' ET"><u><a class="white-text" href="index.php?action=show_account&username=' . $user['username'] . '"> ' . $user['username'] . '</a></u></p>
                </div>';
            $second = false;
        }

        else {
            $html .= '<div class="col l6 push-l6">
                    <p class="white-text tooltipped" data-position="top" data-delay="50" data-tooltip="' . $user['timestamp'] . ' ET"><u><a class="white-text" href="index.php?action=show_account&username=' . $user['username'] . '"> ' . $user['username'] . '</a></u></p>
                </div>';
        }

        $first = false;

    }

    return $html;
}

function get_followers_html($users){
    $html = "";

    $first = true;
    $second = false;

    foreach($users as $user){
        if($first){
            $html .= '<div class="col l6 push-l2">
                    <p class="white-text tooltipped" data-position="top" data-delay="50" data-tooltip="' . $user['timestamp'] . ' ET"><u><a class="white-text" href="index.php?action=show_account&username=' . $user['username'] . '"> ' . $user['username'] . '</a></u></p>
                      </div>';
            $second = true;
        }

        else if($second){
            $html .= '<div class="col l4  white-text">
                        <a href="index.php?action=show_all_bookmarked_users&username=' . $_GET['username'] . '" class="white-text">View All</a>
                    </div>
                      <div class="col l8 push-l2">
                    <p class="white-text tooltipped" data-position="top" data-delay="50" data-tooltip="' . $user['timestamp'] . ' ET"><u><a class="white-text" href="index.php?action=show_account&username=' . $user['username'] . '"> ' . $user['username'] . '</a></u></p>
                </div>';
            $second = false;
        }

        else {
            $html .= '<div class="col l8 push-l6">
                    <p class="white-text tooltipped" data-position="top" data-delay="50" data-tooltip="' . $user['timestamp'] . ' ET"><u><a class="white-text" href="index.php?action=show_account&username=' . $user['username'] . '"> ' . $user['username'] . '</a></u></p>
                </div>';
        }

        $first = false;

    }

    return $html;
}

function get_add_group_alerts(){
    if(isset($_SESSION['add_group'])) {
        $alerts = $_SESSION['add_group'];
        $to_ret = "<scr" . "ipt>Materialize.toast('$alerts', 2000);</script>";
        unset($_SESSION['add_group']);
        return $to_ret;
    }

    else
        return "";
}

function get_lookup_group_alerts(){
    if(isset($_SESSION['lookup_group'])) {
        $alerts = $_SESSION['lookup_group'];
        $to_ret = "<scr" . "ipt>Materialize.toast('$alerts', 2000);</script>";
        unset($_SESSION['lookup_group']);
        return $to_ret;
    }

    else
        return "";
}

function get_join_group_alerts(){
    if(isset($_SESSION['join_group'])) {
        $alerts = $_SESSION['join_group'];
        $to_ret = "<scr" . "ipt>Materialize.toast('$alerts', 2000);</script>";
        unset($_SESSION['join_group']);
        return $to_ret;
    }

    else
        return "";
}

function get_edit_alerts(){
    if(isset($_SESSION['edit_challenge'])) {
        $alerts = $_SESSION['edit_challenge'];
        $to_ret = "<scr" . "ipt>Materialize.toast('$alerts', 2000);</script>";
        unset($_SESSION['edit_challenge']);
        return $to_ret;
    }

    else
        return "";
}

function get_user_group_score($user_id, $group_id){
    $solves = get_total_solves_per_person_per_group($user_id, $group_id);
    $total = 0;
    foreach ($solves as $solve) {
        $total += $solve['difficulty'];
    }

    return $total;

}

function get_html_for_delete_button($problem_id){
    $html = "<button class=\"btn orange\" onclick=\"window.parent.parent.location.href='index.php?action=delete&problem_id=$problem_id'\">Delete</button>";
    return $html;
}


function solved($problem_id, $user_id){
    $solved = get_solved_problems($user_id);

    foreach($solved as $problem){
        if($problem['problem_id'] == $problem_id)
            return true;
    }

    return false;
}

function owns_problem($pid){
    return get_creator_from_id($pid)['user_id'] == $_SESSION['user']['user_id'];

}

function get_exp($user_id){
    return get_num_problems_contributed($user_id) + get_all_attempts_num($user_id) + get_all_solves_num($user_id);
}

function get_activity_phrase($activity){
    //1 -> Added problem
    //2 -> Commented
    //3 -> Post
    //4 -> Post Reply
    //5 -> Submission

    switch ($activity['type']) {
        case 1:
            return "added " . "<a class=\"orange-text\" href=\"index.php?action=find_problem_details&problem_id=" . $activity['id'] . "\">" . htmlspecialchars(get_problem_from_id($activity['id'])['problem_name']) . "</a>";
        case 2:
            return "commented on " . "<a class=\"orange-text\" href=\"index.php?action=find_problem_details&problem_id=" . get_problem_from_id(get_pid_by_cid($activity['id']))['problem_id'] . "\">" . htmlspecialchars(get_problem_from_id(get_pid_by_cid($activity['id']))['problem_name']) . "</a>";
        case 3:
            return 'posted <a class="orange-text" href="index.php?action=view_post&post_id=' . $activity['id'] . '">something interesting</a>';
        case 4:
            return 'replied to a <a class="orange-text" href="index.php?action=view_post&post_id=' . $activity['id'] . '">post</a> ';
        case 5:
            if($activity['x']) {
                return "solved " . "<a class=\"orange-text\" href=\"index.php?action=find_problem_details&problem_id=" . get_problem_from_id(get_pid_by_sid($activity['id']))['problem_id'] . "\">" . htmlspecialchars(get_problem_from_id(get_pid_by_sid($activity['id']))['problem_name'])  ."</a>";
            }
            if(!$activity['x']) {
                return "failed " . "<a class=\"orange-text\" href=\"index.php?action=find_problem_details&problem_id=" . get_problem_from_id(get_pid_by_sid($activity['id']))['problem_id'] . "\">" . htmlspecialchars(get_problem_from_id(get_pid_by_sid($activity['id']))['problem_name'])  ."</a>";
            }
    }
}