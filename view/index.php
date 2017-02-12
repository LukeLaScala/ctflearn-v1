<?php
/**
 * Created by PhpStorm.
 * User: luklas
 * Date: 7/31/16
 * Time: 10:26 PM
 */
session_start();

include 'functions.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(1);

if($_SERVER['HTTP_HOST'] != "ctflearn.com" and $_SERVER['HTTP_HOST'] != 'www.ctflearn.com' and $_SERVER['HTTP_HOST'] != 'localhost:8888' and $_SERVER['HTTP_HOST'] != 'localhost'){
    echo("Please dont frame my site (;");
    echo($_SERVER['HTTP_HOST']);
}

else {

    if (isset($_GET['action']))
        $action = $_GET['action'];
    else {
        $action = "";
    }
    switch ($action) {
        case "show_add_user":
            //18 chars max
            include '../view/registration.php';
            break;

        case "add_user":
            include '../models/db_functions.php';
            $username = '';
            $email = '';
            $password = '';
            $confirmpassword = '';
            $receive_emails = '';


            if (isset($_POST['username']))
                $username = $_POST['username'];

            if (isset($_POST['email']))
                $email = $_POST['email'];

            if (isset($_POST['password']))
                $password = $_POST['password'];

            if (isset($_POST['confirmpassword']))
                $confirmpassword = $_POST['confirmpassword'];

            if (isset($_POST['receive_emails']))
                $receive_emails = $_POST['receive_emails'] == "on";

            if ($password !== $confirmpassword) {
                $_SESSION['registration'] = 'Passwords did not match. ';
                header("Location: index.php?action=show_add_user");
            } else if (username_taken($username)) {
                $_SESSION['registration'] = 'Username is already taken. ';
                header("Location: index.php?action=show_add_user");
            } else if (email_taken($email)) {
                $_SESSION['registration'] = 'Email is already taken. ';
                header("Location: index.php?action=show_add_user");
            } else {
                add_user($username, $password, $email, $receive_emails);
                setcookie("has_account", 1, time() + 86400 * 30);
                $id = get_user($username)['user_id'];
                add_follow($id, 73);
                $_SESSION['registration'] = 'Successfully registered!';
                $_SESSION['needsmodalhome'] = true;
                header("Location: index.php?s=1");
            }

            break;


        case "login":
            include '../models/db_functions.php';

            if (isset($_POST['username']))
                $username = $_POST['username'];
            else
                header("Location: index.php");

            if (isset($_POST['password']))
                $password = $_POST['password'];
            else
                header("Location: index.php");

            log_in($username, $password);
            setcookie("has_account", 1, time() + 86400 * 30);

            if (isset($_SESSION['user']['logged_in'])) {
                $_SESSION['alerts'] = "Successfully logged in!";
                header("Location: index.php");
            } else {
                $_SESSION['alerts'] = "Your email or password is incorrect. ";
                header("Location: index.php?action=show_login");
            }

            break;

        case "logout":
            unset($_SESSION['user']);
            header("Location: index.php");
            break;

        case "show_add_challenge":
            include '../models/db_functions.php';
            $groups = get_user_groups($_SESSION['user']['user_id']);
            include 'add_challenge.php';
            break;

        case "add_challenge":
            require_login();
            include '../models/db_functions.php';
            $user_id = $_SESSION['user']['user_id'];
            $desc = "";
            $name = "";
            $flag = "";
            $difficulty = null;
            $category = "";
            $group_id = "";


            if (isset($_POST['flag']))
                $flag = $_POST['flag'];

            if (isset($_POST['group']))
                $group_id = $_POST['group'];

            if (isset($_POST['difficulty']) and ($_POST['difficulty']) > 0 and ($_POST['difficulty']) < 11)
                $difficulty = $_POST['difficulty'];


            if (isset($_POST['name']))
                $name = $_POST['name'];

            if (isset($_POST['description'])) {
                $desc = $_POST['description'];
            }

            if (isset($_POST['category']) and $_POST['category'] == "Miscellaneous" or $_POST['category'] == "Web Exploitation" or $_POST['category'] == "Cryptography" or $_POST['category'] == "Forensics" or $_POST['category'] == "Binary Exploitation" or $_POST['category'] == "Programming")
                $category = $_POST['category'];


            if ($desc == "" or $name == "" or $flag == "" or $user_id == "" or $difficulty == null or $category == "") {
                $_SESSION['add_challenge'] = "Stop hacking the site!";


                header('Location: index.php');
            } else if (problem_name_taken($name)) {
                $_SESSION['add_challenge'] = "A problem with this name already exists!";
                header('Location: index.php?action=show_add_challenge');
            } else if (isset($group_id) and $group_id != "public") {
                if ($_SESSION['user']['user_id'] != $user_id) {
                    header("Location: WTF");
                }
                add_group_problem($name, $desc, $user_id, $flag, $difficulty, $category, $group_id);
                $_SESSION['add_challenge'] = "Problem added successfully!";
                header('Location: index.php?action=show_group&group=' . get_group_by_id($group_id)['group_name']);
            } else {
                if ($_SESSION['user']['user_id'] != $user_id) {
                    header("Location: WTF");
                }
                add_problem($name, nl2br(htmlspecialchars($desc)), $user_id, $flag, $difficulty, $category);
                $_SESSION['add_challenge'] = "Problem added successfully!";
                header('Location: index.php?action=show_account&username=' . $_SESSION['user']['username']);
            }

            break;

        case "show_scoreboard":
            require_login();
            include '../models/db_functions.php';
            $user_id = $_SESSION['user']['user_id'];
            if (isset($_GET['group_id']) and is_member_of_group($user_id, $_GET['group_id'])) {
                $members = get_group_members($_GET['group_id']);
                $members_scores = array();
                $counter = 0;
                $names = array();
                $scores = array();
                foreach ($members as $member) {
                    $score = (get_score_per_person_per_group($member['user_id'], $_GET['group_id'])['score']);
                    $score = get_score_per_person_per_group($member['user_id'], $_GET['group_id'])['score'];

                    if (get_total_points_available_per_person_per_group($member['user_id'], $_GET['group_id'])['score'] == 0)
                        $score = 0;
                    else {
                        $score = $score / get_total_points_available_per_person_per_group($member['user_id'], $_GET['group_id'])['score'];
                        $score *= 100;
                        $score = round($score, 2);

                    }
                    $name = $member['username'];
                    $scores[$counter] = $score;
                    $names[$counter] = $name;

                    $counter++;
                }

                $length = count($scores);
                for ($i = 1; $i < $length; $i++) {
                    $element = $scores[$i];
                    $element2 = $names[$i];
                    $j = $i;
                    while ($j > 0 && $scores[$j - 1] > $element) {
                        //move value to right and key to previous smaller index
                        $scores[$j] = $scores[$j - 1];
                        $names[$j] = $names[$j - 1];

                        $j = $j - 1;
                    }
                    //put the element at index $j
                    $scores[$j] = $element;
                    $names[$j] = $element2;

                    $scores_reversed = array_reverse($scores);
                    $names_reversed = array_reverse($names);

                }

                include "scoreboard.php";
            } else {
                header("Location: index.php?action=show_group&group=" . get_group_by_id($_GET['group_id'])['group_name']);
            }

            break;

        case "show_unsolved_problems":
            include '../models/db_functions.php';
            require_login();

            if (isset($_GET['sort']))
                $sort = $_GET['sort'];
            else
                $sort = NULL;

            $problem_list = get_unsolved_problems($_SESSION['user']['user_id'], $sort);

            include 'show_unsolved_problems.php';

            break;

        case "show_problems":
            include '../models/db_functions.php';
            require_login();
            $problem_list = get_all_problems($_SESSION['user']['user_id']);

            include 'show_problems.php';

            break;

        case "check_submit":
            require_login();
            include '../models/db_functions.php';

            $flag = "";
            $problem_id = 0;


            if (isset($_POST['flag']))
                $flag = $_POST['flag'];

            else {
                $_SESSION['submit_flag'] = "Some very weird error occured.";
                header("Location: index.php?action=show_unsolved_problems");
            }

            if (isset($_POST['problem_id']))
                $problem_id = $_POST['problem_id'];

            else {
                $_SESSION['submit_flag'] = "Some very weird error occured.";
                header("Location: index.php?action=show_unsolved_problems");
            }

            if (solved($problem_id, $_SESSION['user']['user_id'])) {
                $_SESSION['submit_flag'] = "Error Occured";
                header("Location: index.php?action=show_unsolved_problems");
            }

            if (get_problem_from_id($problem_id)['user_id'] == $_SESSION['user']['user_id']) {
                $_SESSION['submit_flag'] = "You can't solve your own problem!";
                header("Location: index.php");
            }

            $correct_flag = get_flag($problem_id)['flag'];


            $user_id = $_SESSION['user']['user_id'];

            if (get_problem_from_id($problem_id)['user_id'] == $_SESSION['user']['user_id']) {
                $_SESSION['submit_flag'] = "You cannot solve your own problem!";
                header("Location: index.php");
            } else {
                if (strpos(strtoupper($flag), strtoupper($correct_flag)) !== false) {
                    $_SESSION['submit_flag'] = "Correct!";
                    add_submission($problem_id, 1, $user_id);
                } else {
                    $_SESSION['submit_flag'] = "Incorrect!";
                    add_submission($problem_id, 0, $user_id);
                }

                if (isset($_POST['problem_name']) and !isset($_POST['group_submit'])) {
                    header("Location: index.php?action=lookup_problem&problem_name=" . $_POST['problem_name']);
                } else if (isset($_POST['group_submit']) && $_POST['group_submit'] === "1") {
                    header('Location: index.php?action=show_group&group=' . $_SESSION['group']);
                } else {
                    header("Location: index.php?action=show_unsolved_problems");
                }
            }

            break;

        case "check_submit_homepage":
            require_login();
            include '../models/db_functions.php';

            $flag = "";
            $problem_id = 0;


            if (isset($_POST['flag'])) {
                $flag = $_POST['flag'];
            } else {
                $_SESSION['submit_flag'] = "Some very weird error occured.";
                header("Location: index.php");
            }

            if (isset($_POST['problem_id'])) {
                $problem_id = $_POST['problem_id'];

            } else {
                $_SESSION['submit_flag'] = "Some very weird error occured.";
                header("Location: index.php");
            }


            if (solved($problem_id, $_SESSION['user']['user_id'])) {
                $_SESSION['submit_flag'] = "Error occurred";
                header("Location: index.php?action=show_unsolved_problems");
            }


            $correct_flag = get_flag($problem_id)['flag'];


            $user_id = $_SESSION['user']['user_id'];


            if (get_problem_from_id($problem_id)['user_id'] == $_SESSION['user']['user_id']) {
                $_SESSION['submit_flag'] = "You cannot solve your own problem!";
                header("Location: index.php");
            } else {
                if (strpos(strtoupper($flag), strtoupper($correct_flag)) !== false) {
                    $_SESSION['submit_flag'] = "Correct!";
                    add_submission($problem_id, 1, $user_id);
                } else {
                    $_SESSION['submit_flag'] = "Incorrect!";
                    add_submission($problem_id, 0, $user_id);
                }

                if (isset($_POST['problem_name']) and !isset($_POST['group_submit'])) {
                    header("Location: index.php");
                } else {
                    header("Location: index.php");
                }
            }

            break;

        case "check_submit_extended":
            require_login();
            include '../models/db_functions.php';

            $flag = "";
            $problem_id = 0;


            if (isset($_POST['flag'])) {
                $flag = $_POST['flag'];
            } else {
                $_SESSION['submit_flag'] = "Some very weird error occured.";
                header("Location: index.php");
            }

            if (isset($_POST['problem_id'])) {
                $problem_id = $_POST['problem_id'];

            } else {
                $_SESSION['submit_flag'] = "Some very weird error occured.";
                header("Location: index.php");
            }


            if (solved($problem_id, $_SESSION['user']['user_id'])) {
                $_SESSION['submit_flag'] = "Error occurred";
                header("Location: index.php?action=show_unsolved_problems");
            }


            $correct_flag = get_flag($problem_id)['flag'];


            $user_id = $_SESSION['user']['user_id'];


            if (get_problem_from_id($problem_id)['user_id'] == $_SESSION['user']['user_id']) {
                $_SESSION['submit_flag'] = "You cannot solve your own problem!";
                header("Location: index.php");
            } else {
                if (strpos(strtoupper($flag), strtoupper($correct_flag)) !== false) {
                    $_SESSION['submit_flag'] = "Correct!";
                    add_submission($problem_id, 1, $user_id);
                } else {
                    $_SESSION['submit_flag'] = "Incorrect!";
                    add_submission($problem_id, 0, $user_id);
                }

                if (isset($_POST['problem_name']) and !isset($_POST['group_submit'])) {
                    header("Location: index.php?action=find_problem_details&problem_id=" . $problem_id);
                } else {
                    header("Location: index.php?action=find_problem_details&problem_id=" . $problem_id);
                }
            }

            break;


        case "add_comment":
            require_login();
            include "../models/db_functions.php";

            $uid = "";
            $pid = "";
            $comment = "";


            if(isset($_POST['pid'])){
                $pid = $_POST['pid'];
            } else {
                $_SESSION['comment_error'] = "Something went wrong.";
                header("Location: index.php?i=1");
            }

            if(isset($_POST['comment'])){
                $comment = $_POST['comment'];
            } else {
                $_SESSION['comment_error'] = "Something went wrong.";
                header("Location: index.php?i=2");
            }

            if(isset($_SESSION['user']['user_id'])){
                $uid = $_SESSION['user']['user_id'];
            } else {
                $_SESSION['comment_error'] = "Something went wrong.";
                header("Location: index.php?i=3");
            }

            if($uid != "" && $pid != "" && $comment != ""){

                if(isset($_POST['comment_parent'])){
                    add_comment_with_parent($uid, $pid, nl2br(htmlspecialchars($comment)),$_POST['comment_parent']);
                }
                else {
                    add_comment($uid, $pid, nl2br(htmlspecialchars($comment)));
                }
            }

            header("Location: index.php?action=find_problem_details&problem_id=" . $_POST['pid']);

            break;

        case "delete_comment":
            require_login();
            include "../models/db_functions.php";
            $pid = "";
            if (isset($_GET['cid'])) {
                if((get_comment_owner($_GET['cid']) == $_SESSION['user']['user_id']) || $_SESSION['user']['admin']){
                    $pid = get_problem_id_by_comment($_GET['cid']);
                    delete_comment($_GET['cid']);
                }

                header("Location: index.php?action=find_problem_details&problem_id=" . $pid);
            }

            else {
                header("Location: index.php");
            }


            break;

        case "show_account":
            include "../models/db_functions.php";
            if (isset($_GET['username'])) {
                $username = $_GET['username'];
            } else {
                $_SESSION['lookup_user'] = "Could not find that user!";
                header("Location: index.php?action=show_account_lookup");
            }

            if (get_user($username)) {
                $user = get_user($username);
                $recent_submissions = get_recent_submissions_per_user($user['user_id']);

            } else {
                $_SESSION['lookup_user'] = "Could not find that user!";
                header("Location: index.php?action=show_account_lookup");
            }

            include 'account.php';
            break;

        case "show_all_problems_solved":
            require_login();
            include "../models/db_functions.php";
            $user = "";

            if (isset($_GET['username'])) {
                $username = $_GET['username'];
            } else {
                $_SESSION['lookup_user'] = "Could not find thdat user!";
                header("Location: index.php");
            }

            if (get_user($username)) {
                $user = get_user($username);
            } else {
                $_SESSION['lookup_user'] = "Could not find thsat user!";
                header("Location: index.php");
            }

            $problem_list = get_solved_problems($user['user_id']);
            include "show_all_problems_solved.php";

            break;
        case "show_all_problems":
            include "../models/db_functions.php";

            $problem_list = get_all_problems_raw();

            include 'show_all_problems.php';
            break;


        case "show_all_problems_added":
            require_login();
            include "../models/db_functions.php";
            $user = "";

            if (isset($_GET['username'])) {
                $username = $_GET['username'];
            } else {
                $_SESSION['lookup_user'] = "Could not find that user!";
                header("Location: index.php");
            }

            if (get_user($username)) {
                $user = get_user($username);
            } else {
                $_SESSION['lookup_user'] = "Could not find that user!";
                header("Location: index.php");
            }

            $problem_list = get_all_problems_contributed($user['user_id']);
            include "show_all_problems_added.php";

            break;

        case "lookup_problem":
            require_login();
            include "../models/db_functions.php";

            $user_id = $_SESSION['user']['user_id'];

            if (isset($_GET['problem_name']))
                $problem_name = $_GET['problem_name'];
            else
                $problem_name = null;


            $problem_list = get_unsolved_problems_by_name($user_id, $problem_name);

            include 'problem_lookup.php';
            break;

        case "show_account_lookup":
            require_login();
            include 'show_account_lookup.php';
            break;

        case "show_problem_lookup":
            require_login();
            include 'show_problem_lookup.php';
            break;

        case "find_problem_details":
            include "../models/db_functions.php";
            $problem_id = $_GET['problem_id'];
            include 'problemextended.php';
            break;

        case "show_all_following":
            require_login();
            include "../models/db_functions.php";
            $user = "";

            if (isset($_GET['username'])) {
                $username = $_GET['username'];

            } else {
                $_SESSION['lookup_user'] = "Could not find that user!";
                header("Location: index.php");
            }

            if (get_user($username)) {
                $user = get_user($username);
            } else {
                $_SESSION['lookup_user'] = "Could not find that user!";
                header("Location: index.php");
            }

            $user_list = get_following($user['user_id']);
            include "show_all_following.php";

            break;

        case "show_all_followers":
            require_login();
            include "../models/db_functions.php";
            $user = "";

            if (isset($_GET['username'])) {
                $username = $_GET['username'];

            } else {
                $_SESSION['lookup_user'] = "Could not find that user!";
                header("Location: index.php");
            }

            if (get_user($username)) {
                $user = get_user($username);
            } else {
                $_SESSION['lookup_user'] = "Could not find that user!";
                header("Location: index.php");
            }

            $user_list = get_followers($user['user_id']);
            include "show_all_followers.php";

            break;

        case "follow":
            require_login();
            include "../models/db_functions.php";

            $friend_id = null;
            if (!isset($_GET['friend_id'])) {
                $_SESSION['follow'] = "Something went wrong.";
                header("Location: index.php?action=show_account&username=" . $friend['username']);
            } else {
                $friend_id = $_GET['friend_id'];
            }

            $friend = get_user_by_id($friend_id);


            if (already_following($_SESSION['user']['user_id'], $friend_id)) {
                $_SESSION['follow'] = "Something went wrong.";
                header("Location: index.php?action=show_account&username=" . $friend['username']);
            } else {
                add_follow($_SESSION['user']['user_id'], $friend_id);
                $_SESSION['follow'] = "Success!";
                header("Location: index.php?action=show_account&username=" . $friend['username']);
            }

            break;

        case "unfollow":
            require_login();
            include "../models/db_functions.php";

            $friend_id = null;
            if (!isset($_GET['friend_id'])) {
                $_SESSION['follow'] = "Something went wrong.";
                header("Location: index.php?action=show_account&username=" . $friend['username']);
            } else {
                $friend_id = $_GET['friend_id'];
            }

            $friend = get_user_by_id($friend_id);


            if (!already_following($_SESSION['user']['user_id'], $friend_id)) {
                $_SESSION['follow'] = "Something went wrong.";
                header("Location: index.php?action=show_account&username=" . $friend['username']);
            } else {
                remove_follow($_SESSION['user']['user_id'], $friend_id);
                $_SESSION['follow'] = "Success!";
                header("Location: index.php?action=show_account&username=" . $friend['username']);
            }

            break;

        case "upload":
            require_login();
            include '../models/db_functions.php';
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $target_file = md5($target_file);

            if (isset($_POST["submit"])) {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if ($check !== 1) {
                    $uploadOk = 1;
                } else {
                    $_SESSION['upload'] = "File is not an image.";
                    $uploadOk = 0;
                }
            }

            if (file_exists($target_file)) {
                $_SESSION['upload'] = "Sorry, file already exists.";
                $uploadOk = 0;
            }

            if ($_FILES["fileToUpload"]["size"] > 50000000) {
                $_SESSION['upload'] = "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $_SESSION['upload'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            if ($uploadOk == 0) {
                //$_SESSION['upload'] = "Sorry, your file was not uploaded.";

            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], 'uploads/' . $target_file)) {

                    $_SESSION['upload'] = "Your profile picture has been changed.";
                    update_profile_picture($_SESSION['user']['user_id'], $target_file);
                } else {
                    $_SESSION['upload'] = "Error uploading your picture.";
                }
            }


            header('Location: index.php?action=show_account&username=' . $_SESSION['user']['username']);
            break;

        case "show_add_group":
            require_login();
            include "add_group.php";
            break;

        case "add_group":
            require_login();
            include '../models/db_functions.php';

            $name = '';
            $password = '';

            if (isset($_POST['password']))
                $password = $_POST['password'];

            if (isset($_POST['group_name']))
                $name = $_POST['group_name'];

            if (group_name_taken($name)) {
                $_SESSION['add_group'] = 'Name is already taken. ';
                header("Location: index.php?action=show_add_group");
            } else if (get_num_groups_made($_SESSION['user']['user_id']) >= 3 && !$_SESSION['user']['admin']) {
                $_SESSION['add_group'] = 'Too many groups created.';
                header("Location: index.php?action=show_add_group");
            } else {
                add_group($name, $password, $_SESSION['user']['user_id']);
                $_SESSION['add_group'] = 'Success!';
                $group = get_group_by_name($name);
                join_group($group['group_id'], $_SESSION['user']['user_id']);
                header("Location: index.php?action=show_account&username=" . $_SESSION['user']['username']);
            }

            break;


            break;

        case "show_group":
            require_login();
            include '../models/db_functions.php';
            $group = "";
            if (isset($_GET['group'])) {
                $group = get_group_by_name($_GET['group']);

                //for returning to group when a problem is submitted
                $_SESSION['group'] = $_GET['group'];
            } else {
                $_SESSION['lookup_group'] = "Weird!";
                header("Location: index.php?action=show_group_lookup");
            }

            if (!$group) {
                $_SESSION['lookup_group'] = "No group with that name!";
                header("Location: index.php?action=show_group_lookup");
            }

            if (!is_member_of_group($_SESSION['user']['user_id'], $group['group_id'])) {
                header("Location: index.php?action=show_join_group&group=" . $group['group_name']);
            } else {

                if (isset($_GET['sort']))
                    $sort = $_GET['sort'];
                else
                    $sort = NULL;

                $problem_list = get_all_problems_per_group($_SESSION['user']['user_id'], $sort, $group['group_id']);


                include 'group.php';

            }


            break;

        case "show_join_group":
            require_login();
            include '../models/db_functions.php';
            $group = "";
            if (isset($_GET['group'])) {
                $group = get_group_by_name($_GET['group']);
            } else {
                $_SESSION['lookup_group'] = "Weird!";
                header("Location: index.php?action=show_group_lookup");
            }

            if (!$group) {
                $_SESSION['lookup_group'] = "No group with that name!";
                header("Location: index.php?action=show_group_lookup");
            }

            if (is_member_of_group($_SESSION['user']['user_id'], $group['group_id'])) {
                $_SESSION['lookup_group'] = "You are already a member!";
                header("Location: index.php?action=show_group_lookup");
            } else {
                include 'show_join_group.php';
            }


            break;

        case "show_group_lookup":
            require_login();
            include 'show_lookup_group.php';

            break;

        case "join_group":
            require_login();
            include "../models/db_functions.php";
            $password = "";
            $group = "";
            if (isset($_POST['password']) and isset($_POST['group'])) {
                $password = $_POST['password'];
                $group = $_POST['group'];
            }

            $group = get_group_by_name($group);

            if (!$group) {
                header("Location: index.php?action=show_join_group&group=" . $group['group_name']);
            }

            if ($group['group_password'] != $password) {
                $_SESSION['join_group'] = "Wrong password";
                header("Location: index.php?action=show_join_group&group=" . $group['group_name']);
            } else {
                join_group($group['group_id'], $_SESSION['user']['user_id']);
                $_SESSION['join_group'] = "Success!";
                header("Location: index.php?action=show_group&group=" . $group['group_name']);
            }

            break;

        case "delete":
            require_login();
            include "../models/db_functions.php";
            $user_id = $_SESSION['user']['user_id'];
            $problem_id = $_GET['problem_id'];

            if ($_SESSION['user']['admin'] or is_leader_of_group($_SESSION['user']['user_id'], get_problem_from_id($problem_id)['group_id']) or owns_problem($problem_id))
                delete_problem($problem_id);

            header("Location: index.php?action=show_account&username=" . $_SESSION['user']['username']);
            break;

        case "show_edit":
            require_login();
            include "../models/db_functions.php";
            $user_id = $_SESSION['user']['user_id'];
            $problem_id = $_GET['problem_id'];
            if (!owns_problem($problem_id)) {
                header("Location: index.php");
            }
            $problem = get_problem_from_id($problem_id);

            $problem_name = $problem['problem_name'];
            $flag = $problem['flag'];
            $desc = $problem['problem_description'];
            $difficulty = $problem['difficulty'];
            $category = $problem['category'];


            include "edit_problem.php";

            break;

        case "edit_challenge":
            require_login();
            include "../models/db_functions.php";
            require_login();
            $user_id = $_SESSION['user']['user_id'];
            $desc = "";
            $flag = "";
            $difficulty = null;
            $category = "";
            $group_id = "";
            $pid = "";

            if (isset($_POST['flag']))
                $flag = $_POST['flag'];

            if (isset($_POST['group']))
                $group_id = $_POST['group'];

            if (isset($_POST['difficulty']) and ($_POST['difficulty']) > 0 and ($_POST['difficulty']) < 11)
                $difficulty = $_POST['difficulty'];

            if (isset($_POST['pid']))
                $pid = $_POST['pid'];

            if (isset($_POST['description'])) {
                $desc = $_POST['description'];
            }

            if (isset($_POST['category']) and $_POST['category'] == "Miscellaneous" or $_POST['category'] == "Web Exploitation" or $_POST['category'] == "Cryptography" or $_POST['category'] == "Forensics" or $_POST['category'] == "Binary Exploitation" or $_POST['category'] == "Programming")
                $category = $_POST['category'];


            if ($desc == "" or $pid == "" or $flag == "" or $user_id == "" or $difficulty == null or $category == "") {
                $_SESSION['edit_challenge'] = "Stop hacking the site!";

                header('Location: index.php?action=show_account&username=' . $_SESSION['user']['username']);
            } else if (!owns_problem($pid)) {
                $_SESSION['edit_challenge'] = "Stop hacking the site!";

                header('Location: index.php?action=show_account&username=' . $_SESSION['user']['username']);
            } else {
                edit_problem($desc, $user_id, $flag, $difficulty, $category, $pid);
                $_SESSION['edit_challenge'] = "Problem edited successfully!";
                header('Location: index.php?action=show_account&username=' . $_SESSION['user']['username']);
            }

            break;


            break;

        case "leave_group":
            require_login();
            include "../models/db_functions.php";
            $user_id = $_SESSION['user']['user_id'];
            $group_id = $_GET['group_id'];


            leave_group($group_id, $user_id);

            $_SESSION['leave_group'] = "Success!";

            $group_user_id = get_group_leader($group_id)['user_id'];

            if ($user_id == $group_user_id and get_num_users_per_group($group_id) >= 1) {
                change_group_leader($group_id, get_new_group_leader($group_id)['user_id']);
            }

            if (get_num_users_per_group($group_id) == 0) {
                delete_group($group_id);
            }

            header("Location: index.php?action=show_account&username=" . $_SESSION['user']['username']);


            break;

        case "stats":
            include "../models/db_functions.php";
            include "stats.php";


            break;

        case "scoreboard":
            include "../models/db_functions.php";
            $members = get_all_users();
            $members_scores = array();
            $counter = 0;
            $names = array();
            $scores = array();
            foreach ($members as $member) {
                $score = get_score_per_person($member['user_id'])['score'];
                $score = $score / get_total_points_available_per_person($member['user_id'])['score'];
                $score *= 100;
                $score = round($score, 2);
                $name = $member['username'];
                $scores[$counter] = $score;
                $names[$counter] = $name;

                $counter++;
            }

            $length = count($scores);
            for ($i = 1; $i < $length; $i++) {
                $element = $scores[$i];
                $element2 = $names[$i];
                $j = $i;
                while ($j > 0 && $scores[$j - 1] > $element) {
                    //move value to right and key to previous smaller index
                    $scores[$j] = $scores[$j - 1];
                    $names[$j] = $names[$j - 1];

                    $j = $j - 1;
                }
                //put the element at index $j
                $scores[$j] = $element;
                $names[$j] = $element2;

                $scores_reversed = array_reverse($scores);
                $names_reversed = array_reverse($names);

            }

            include 'scoreboard.php';

            break;

        case "activity":
            include '../models/db_functions.php';
            $recent_problems = get_followings_problems($_SESSION['user']['user_id']);
            $recent_submissions = get_followings_submissions($_SESSION['user']['user_id']);
            include('activity.php');
            break;

        case "global_activity":
            include '../models/db_functions.php';
            $recent_problems = get_recent_problems($_SESSION['user']['user_id']);
            $recent_submissions = get_recent_submissions($_SESSION['user']['user_id']);
            $recent_comment = get_recent_comments();

            include('globalactivity.php');
            break;
        case "show_login":
            include 'login.php';
            break;
        case "solves":
            include '../models/db_functions.php';
            if (isset($_GET['pid']))
                $pid = $_GET['pid'];
            else
                $pid = null;

            $problem = get_problem_from_id($pid);
            $solves = get_solves($pid);

            include "solves.php";
            break;

        case "admin":
            require_login();
            include 'admin.php';
            break;

        case "help":
            include "about.php";
            break;

        case "dev":
            include "../models/db_functions.php";
            include "dev.php";
            break;

        case "slack":
            include 'slack.php';
            break;

        case "add_post":
            require_login();
            include '../models/db_functions.php';

            if(isset($_POST['post']) && strlen($_POST['post']) <= 400){
                add_post(nl2br(htmlspecialchars($_POST['post'])), $_SESSION['user']['user_id'], false);
                $_SESSION['alerts'] = 'Successfully posted';
            }

            header('Location: index.php');
            break;

        case "add_admin_post":
            require_login();
            include '../models/db_functions.php';

            if(!$_SESSION['user']['admin']){
                header("Location: index.php");
            }
            if(isset($_POST['post']) && strlen($_POST['post']) <= 400){
                add_post(nl2br($_POST['post']), $_SESSION['user']['user_id'], true);
                $_SESSION['alerts'] = 'Successfully posted';
            }

            header('Location: index.php');
            break;

        case "view_post":
            include '../models/db_functions.php';
            if(!isset($_GET['post_id'])){
                header("Location: index.php");
            }
            else {
                $post = get_post_by_id($_GET['post_id']);
                include 'view_post.php';
            }
            break;

        case "reply":
            include '../models/db_functions.php';
            require_login();
            if(isset($_POST['parent_post_id']) and isset($_POST['reply'])){
                add_reply_with_parent($_POST['parent_post_id'], $_SESSION['user']['user_id'], htmlspecialchars($_POST['reply']), $_POST['reply_parent']);
                header('Location: index.php?action=view_post&post_id=' . $_POST['parent_post_id']);

            } else {
                if(isset($_POST['reply']) and isset($_POST['post_id'])){
                    add_reply($_POST['post_id'], $_SESSION['user']['user_id'], nl2br(htmlspecialchars($_POST['reply'])));
                } else{
                    header("Location: index.php");
                }

                header('Location: index.php?action=view_post&post_id=' . $_POST['post_id']);
            }
            break;

        case "view_all_posts":
            include '../models/db_functions.php';
            if(isset($_GET['type'])){
                if($_GET['type'] == 'other'){
                    $posts = get_posts(PHP_INT_MAX);
                }
                else {
                    $posts = get_admin_posts(PHP_INT_MAX);
                }

                include 'allnews.php';
            }

            break;
        case "delete_reply":
            require_login();
            include '../models/db_functions.php';
            if((isset($_GET['rid']) && ($_SESSION['user']['user_id'] == get_reply_owner($_GET['rid']))) || $_SESSION['user']['admin']){
                delete_reply($_GET['rid']);
                $_SESSION['alerts'] = "Success!";
            }

            header('Location: index.php?action=view_post&post_id=' . $_SESSION['return_post_id']);

            break;
        case "delete_post":
            require_login();
            include '../models/db_functions.php';
            if((isset($_GET['post_id']) && ($_SESSION['user']['user_id'] == get_post_owner($_GET['post_id']))) || $_SESSION['user']['admin']){
                delete_post($_GET['post_id']);
                $_SESSION['alerts'] = "Success!";
            }

            header('Location: index.php');

            break;



        default:
            include '../models/db_functions.php';
            $problems = get_x_recent_problems(2);
            include 'home.php';
    }
}
?>
