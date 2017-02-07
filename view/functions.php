<?php

/**
 * Created by PhpStorm.
 * User: luklas
 * Date: 8/1/16
 * Time: 3:31 PM
 */

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
        $_SESSION['require_login'] = "You need to login! ";
        header("Location: index.php?action=show_login");
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