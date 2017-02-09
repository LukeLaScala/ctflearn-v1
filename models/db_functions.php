<?php
require('db_connection.php');

/**
 * Created by PhpStorm.
 * User: luklas
 * Date: 7/31/16
 * Time: 10:54 PM
 */

function add_user($username, $password, $email, $receive_emails)
{
    global $dbh;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $dbh->prepare("INSERT INTO users (username, hashed_password, email, receive_emails) VALUES (:username, :hashed_password, :email, :receive_emails)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':hashed_password', $hashed_password);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':receive_emails', $receive_emails);
    $stmt->execute();
}

function add_problem($name, $desc, $user_id, $flag, $difficulty, $category)
{
    global $dbh;
    $stmt = $dbh->prepare("INSERT INTO problems (problem_name, problem_description, user_id, flag, difficulty, category) VALUES (:name, :desc, :user_id, :flag, :difficulty, :category)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':desc', $desc);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':flag', $flag);
    $stmt->bindParam(':difficulty', $difficulty);
    $stmt->bindParam(':category', $category);

    $stmt->execute();
}

function add_group_problem($name, $desc, $user_id, $flag, $difficulty, $category, $group_id)
{
    global $dbh;
    $stmt = $dbh->prepare("INSERT INTO problems (problem_name, problem_description, user_id, flag, difficulty, category, group_id) VALUES (:name, :desc, :user_id, :flag, :difficulty, :category, :group_id)");

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':desc', $desc);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':flag', $flag);
    $stmt->bindParam(':difficulty', $difficulty);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':group_id', $group_id);

    $stmt->execute();
}

function edit_problem($desc, $user_id, $flag, $difficulty, $category, $pid)
{
    global $dbh;
    $stmt = $dbh->prepare("update problems set problem_description=:desc, user_id=:user_id, flag=:flag, difficulty=:difficulty, category=:category where problem_id = :pid");
    $stmt->bindParam(':desc', $desc);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':flag', $flag);
    $stmt->bindParam(':difficulty', $difficulty);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':pid', $pid);


    $stmt->execute();
}

function username_taken($username)
{
    global $dbh;
    $stmt = $dbh->prepare("SELECT * from users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return !empty($result) ? true : false;
}

function problem_name_taken($problem_name)
{
    global $dbh;
    $stmt = $dbh->prepare("SELECT * from problems WHERE problem_name = :name");
    $stmt->bindParam(':name', $problem_name);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return !empty($result) ? true : false;
}

function email_taken($email)
{
    global $dbh;
    $stmt = $dbh->prepare("SELECT * from users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return !empty($result) ? true : false;
}

function log_in($username, $password)
{
    global $dbh;

    $stmt = $dbh->prepare("SELECT hashed_password,user_id,username,is_admin from users WHERE username = :username or email = :username ");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (password_verify($password, $row['hashed_password'])) {
        $_SESSION['user'] = Array();
        $_SESSION['user']['user_id'] = $row['user_id'];
        $_SESSION['user']['username'] = $row['username'];
        $_SESSION['user']['admin'] = $row['is_admin'];
        $_SESSION['user']['logged_in'] = true;
    }

    return;

}

function get_all_problems($user_id)
{


    $sql = "select *, p.problem_id as pid from problems p left join submissions s on s.problem_id = p.problem_id and s.user_id = :user_id inner join users u on u.user_id = p.user_id where not exists (
    select *
    from submissions high
    where high.problem_id = s.problem_id
    and high.user_id = :user_id
    and high.submission_id > s.submission_id
)  and (p.group_id = 0 or p.group_id is null) ";


    global $dbh;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);

    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function get_all_problems_per_group($user_id, $sort, $group_id)
{

    $sql = "select *, p.problem_id as pid from problems p left join submissions s on s.problem_id = p.problem_id and s.user_id = :user_id inner join users u on u.user_id = p.user_id where not exists (
    select *
    from submissions high
    where high.problem_id = s.problem_id
    and high.user_id = :user_id
    and high.submission_id > s.submission_id
) and (p.group_id = :group_id ";


    switch ($sort) {
        case "binary":
            $sql .= "and p.category = \"Binary Exploitation\")";
            break;
        case "misc":
            $sql .= "and p.category = \"Miscellaneous\")";
            break;
        case "web":
            $sql .= "and p.category = \"Web Exploitation\")";
            break;
        case "forensics":
            $sql .= "and p.category = \"Forensics\")";
            break;
        case "crypto":
            $sql .= "and p.category = \"Cryptography\")";
            break;
        case "programming":
            $sql .= "and p.category = \"Programming\")";
            break;
        default:
            $sql .= ")";


    }

    global $dbh;

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':group_id', $group_id);
    $stmt->bindParam(':user_id', $user_id);


    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function get_unsolved_problems($user_id, $sort)
{


    $sql = "select *, p.problem_id as pid from problems p left join submissions s on s.problem_id = p.problem_id and s.user_id = :user_id inner join users u on u.user_id = p.user_id where not exists (
    select *
    from submissions high
    where high.problem_id = s.problem_id
    and high.user_id = :user_id
    and high.submission_id > s.submission_id
)  and u.user_id != :user_id and (s.correct IS null or s.correct = 0) and (p.group_id = 0 or p.group_id is null) ";


    switch ($sort) {
        case "binary":
            $sql .= "and p.category = \"Binary Exploitation\"";
            break;
        case "misc":
            $sql .= "and p.category = \"Miscellaneous\"";
            break;
        case "web":
            $sql .= "and p.category = \"Web Exploitation\"";
            break;
        case "forensics":
            $sql .= "and p.category = \"Forensics\"";
            break;
        case "crypto":
            $sql .= "and p.category = \"Cryptography\"";
            break;
        case "programming":
            $sql .= "and p.category = \"Programming\")";
            break;
    }


    global $dbh;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);


    $stmt->execute();

    $result = $stmt->fetchAll();
    return $result;
}


function get_unsolved_problems_per_group($user_id, $sort, $group_id)
{


    $sql = "select *, p.problem_id as pid from problems p left join submissions s on s.problem_id = p.problem_id and s.user_id = :user_id inner join users u on u.user_id = p.user_id where not exists (
    select *
    from submissions high
    where high.problem_id = s.problem_id
    and high.user_id = :user_id
    and high.submission_id > s.submission_id
)  and u.user_id != :user_id and (cur.correct IS null or cur.correct = 0) and (p.group_id = :group_id) ";


    switch ($sort) {
        case "binary":
            $sql .= "and p.category = \"Binary Exploitation\"";
            break;
        case "misc":
            $sql .= "and p.category = \"Miscellaneous\"";
            break;
        case "web":
            $sql .= "and p.category = \"Web Exploitation\"";
            break;
        case "forensics":
            $sql .= "and p.category = \"Forensics\"";
            break;
        case "crypto":
            $sql .= "and p.category = \"Cryptography\"";
            break;
        case "programming":
            $sql .= "and p.category = \"Programming\")";
            break;
    }


    global $dbh;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':group_id', $group_id);

    $stmt->execute();

    $result = $stmt->fetchAll();
    return $result;
}

function get_unsolved_problems_by_name($user_id, $problem_name)
{

    $problem_name = '%' . $problem_name . '%';

    $sql = "select *, p.problem_id as pid from problems p left join submissions s on s.problem_id = p.problem_id and s.user_id = :user_id inner join users u on u.user_id = p.user_id where not exists (
    select *
    from submissions high
    where high.problem_id = s.problem_id
    and high.user_id = :user_id
    and high.submission_id > s.submission_id
)  and u.user_id != :user_id and (p.problem_name like :problem_name) and (s.user_id = :user_id or s.user_id is null) and (p.group_id = 0 or p.group_id is null)";


    global $dbh;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);

    $stmt->bindParam(':problem_name', $problem_name);

    $stmt->execute();

    $result = $stmt->fetchAll();
    return $result;
}

function get_num_solves($problem_id)
{
    global $dbh;
    $stmt = $dbh->prepare("select * from submissions where problem_id = :problem_id and correct = 1");
    $stmt->bindParam(':problem_id', $problem_id);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return count($result);
}

function get_solves($pid){
    global $dbh;
    $stmt = $dbh->prepare("select * from submissions s inner join problems p on p.problem_id = s.problem_id inner join users u on s.user_id = u.user_id where s.problem_id = :pid and s.correct = 1 order by submission_time desc");
    $stmt->bindParam(':pid', $pid);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function get_problem_by_name($name){
    global $dbh;
    $stmt = $dbh->prepare("select * from problems where problem_name = :name");
    $stmt->bindParam('name', $name);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_score_per_person_per_group($user_id, $group_id){
    global $dbh;
    $stmt = $dbh->prepare("select *, sum(difficulty) score from submissions s inner join problems p on p.problem_id = s.problem_id where p.group_id = :group_id and s.user_id = :user_id and s.correct = 1");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':group_id', $group_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return ($result);
}

function get_total_points_available_per_person($user_id){
    global $dbh;
    $stmt = $dbh->prepare("select sum(difficulty) score from problems where (group_id is null or group_id = 0) and user_id != :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return ($result);
}

function get_total_points_available_per_person_per_group($user_id, $group_id){
    global $dbh;
    $stmt = $dbh->prepare("select sum(difficulty) score from problems where (group_id is null or group_id = 0) and user_id != :user_id and group_id = :group_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':group_id', $group_id);

    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return ($result);
}

function get_followings_problems($user_id){
    $sql = "select * from bookmarks b inner join problems p on p.user_id = b.friend_id inner join users u on u.user_id = p.user_id where b.user_id = :user_id order by timestamp limit 7";


    global $dbh;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);

    $stmt->execute();

    $result = $stmt->fetchAll();
    return ($result);
}

function get_followings_submissions($user_id){
    $sql = "select * from bookmarks b inner join submissions s on s.user_id = b.friend_id inner join users u on u.user_id = s.user_id inner join problems p on p.problem_id = s.problem_id where b.user_id = :user_id order by s.submission_time desc limit 7";


    global $dbh;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);

    $stmt->execute();

    $result = $stmt->fetchAll();
    return ($result);
}

function get_recent_submissions($user_id){
    $sql = "select * from submissions s inner join users u on u.user_id = s.user_id inner join problems p on p.problem_id = s.problem_id order by s.submission_time desc limit 7";


    global $dbh;
    $stmt = $dbh->prepare($sql);
    //$stmt->bindParam(':user_id', $user_id);

    $stmt->execute();

    $result = $stmt->fetchAll();
    return ($result);
}

function get_recent_submissions_per_user($user_id){
    $sql = "select * from submissions s inner join users u on u.user_id = s.user_id inner join problems p on p.problem_id = s.problem_id where s.user_id = :user_id order by s.submission_time desc limit 10";


    global $dbh;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);

    $stmt->execute();

    $result = $stmt->fetchAll();
    return ($result);
}

function get_recent_problems($user_id){
    $sql = "select * from problems p inner join users u on u.user_id = p.user_id order by add_time desc limit 7";


    global $dbh;
    $stmt = $dbh->prepare($sql);
    //$stmt->bindParam(':user_id', $user_id);

    $stmt->execute();

    $result = $stmt->fetchAll();
    return ($result);
}

function get_score_per_person($user_id){
    global $dbh;
    $stmt = $dbh->prepare("select *, sum(difficulty) score from submissions s inner join problems p on p.problem_id = s.problem_id where s.user_id = :user_id and s.correct = 1");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return ($result);
}

function get_flag($problem_id)
{
    global $dbh;
    $stmt = $dbh->prepare("select * from problems where problem_id = :problem_id");
    $stmt->bindParam(':problem_id', $problem_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_user($username)
{
    global $dbh;
    $stmt = $dbh->prepare("select * from users where username= :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_user_by_id($user_id)
{
    global $dbh;
    $stmt = $dbh->prepare("select * from users where user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function add_submission($problem_id, $is_correct, $user_id)
{
    global $dbh;
    $stmt = $dbh->prepare("INSERT INTO submissions (problem_id, correct, user_id) VALUES (:problem_id, :is_correct, :user_id)");
    $stmt->bindParam(':problem_id', $problem_id);
    $stmt->bindParam(':is_correct', $is_correct);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
}

function get_recently_solved_problems($user_id)
{
    global $dbh;
    $stmt = $dbh->prepare("select * from submissions s join problems p on s.problem_id = p.problem_id where s.user_id = :user_id and s.correct = true limit 3");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetchAll();

    return $result;

}

function get_solved_problems($user_id)
{


    $sql = "select *, p.problem_id as pid from problems p left join submissions s on s.problem_id = p.problem_id and s.user_id = :user_id inner join users u on u.user_id = p.user_id where not exists (
    select *
    from submissions high
    where high.problem_id = s.problem_id
    and high.user_id = :user_id
    and high.submission_id > s.submission_id
)  and u.user_id != :user_id and (s.correct = 1) and (p.group_id = 0 or p.group_id is null)";


    global $dbh;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);

    $stmt->execute();

    $result = $stmt->fetchAll();
    return ($result);
}

function get_recently_added_problems()
{


    $sql = "select * from problems p where p.group_id is null or p.group_id = 0 order by p.problem_id desc limit 3";


    global $dbh;
    $stmt = $dbh->prepare($sql);

    $stmt->execute();

    $result = $stmt->fetchAll();
    return ($result);
}

function get_random_problems(){
    $sql = "select * from problems where group_id is null or group_id = 0 order by RAND() limit 3";

    global $dbh;
    $stmt = $dbh->prepare($sql);

    $stmt->execute();

    $result = $stmt->fetchAll();
    return ($result);
}

function update_profile_picture($user_id, $url)
{


    $sql = "update users set profile_picture_path = :url WHERE user_id = :user_id";


    global $dbh;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':url', $url);
    $stmt->bindParam(':user_id', $user_id);


    $stmt->execute();

}

function get_num_solved_problems($user_id)
{


    $sql = "select *, p.problem_id as pid from problems p left join submissions s on s.problem_id = p.problem_id and s.user_id = :user_id inner join users u on u.user_id = p.user_id where not exists (
    select *
    from submissions high
    where high.problem_id = s.problem_id
    and high.user_id = :user_id
    and high.submission_id > s.submission_id
)  and u.user_id != :user_id and (s.correct = 1) and (p.group_id = 0 or p.group_id is null)";


    global $dbh;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);

    $stmt->execute();

    $result = $stmt->fetchAll();
    return count($result);
}

function get_num_problems_contributed($user_id)
{
    global $dbh;
    return(count(get_all_problems_contributed($user_id)));

}

function get_all_problems_contributed($user_id)
{
    global $dbh;
    $stmt = $dbh->prepare("select *, problem_id as pid from problems p inner join users u on p.user_id = u.user_id where u.user_id = :user_id and (p.group_id = 0 or p.group_id is null)");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;

}

function get_recent_following($user_id)
{
    global $dbh;
    $stmt = $dbh->prepare("select * from bookmarks b inner join users u on b.friend_id = u.user_id where b.user_id = :user_id limit 3");
    debug_to_console($user_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function get_following($user_id)
{
    global $dbh;
    $stmt = $dbh->prepare("select * from bookmarks b inner join users u on b.friend_id = u.user_id where b.user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function get_recent_followers($user_id)
{
    global $dbh;
    $stmt = $dbh->prepare("select * from bookmarks b inner join users u on b.friend_id = u.user_id where b.friend_id = 64 limit 3");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function get_followers($user_id)
{
    global $dbh;
    $stmt = $dbh->prepare("select * from bookmarks b inner join users u on b.user_id = u.user_id where friend_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function add_follow($user_id, $friend_id)
{
    global $dbh;
    $stmt = $dbh->prepare("INSERT INTO bookmarks (user_id, friend_id) VALUES (:user_id, :friend_id)");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':friend_id', $friend_id);
    $stmt->execute();
}

function remove_follow($user_id, $friend_id)
{
    global $dbh;
    $stmt = $dbh->prepare("delete from bookmarks where friend_id = :friend_id and user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':friend_id', $friend_id);
    $stmt->execute();
}

function already_following($user_id, $friend_id)
{
    global $dbh;
    $stmt = $dbh->prepare("select * from bookmarks where friend_id = :friend_id and user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':friend_id', $friend_id);
    $stmt->execute();
    $result = $stmt->fetchAll();

    return (count($result) == 1);
}

function num_following($user_id)
{
    global $dbh;
    $stmt = $dbh->prepare("select * from bookmarks b inner join users u on b.friend_id = u.user_id where b.user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetchAll();

    return count($result);
}

function num_followers($user_id)
{
    global $dbh;
    $stmt = $dbh->prepare("select * from bookmarks b inner join users u on b.friend_id = u.user_id where b.friend_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetchAll();

    return count($result);
}

function get_hack_score($user_id)
{
    $followers = num_followers($user_id);
    $following = num_following($user_id);
    $contributed = count(get_all_problems_contributed($user_id));
    $solved = count(get_solved_problems($user_id));
    $solved_problems = get_solved_problems($user_id);


}

function group_name_taken($name)
{
    global $dbh;
    $stmt = $dbh->prepare("SELECT * from groups WHERE group_name = :name");
    $stmt->bindParam(':name', $name);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return count($result) >= 1;

}

function get_num_groups_made($user_id)
{
    global $dbh;
    $stmt = $dbh->prepare("SELECT * from groups WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return count($result);
}

function add_group($group_name, $password, $user_id)
{
    global $dbh;
    $stmt = $dbh->prepare("INSERT INTO groups (group_name, group_password, user_id) VALUES (:group_name, :password, :user_id)");
    $stmt->bindParam(':group_name', $group_name);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':user_id', $user_id);

    $stmt->execute();
}

function join_group($group_id, $user_id)
{
    global $dbh;
    $stmt = $dbh->prepare("INSERT INTO groups_joined (user_id, group_id) VALUES (:user_id, :group_id)");
    $stmt->bindParam(':group_id', $group_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
}

function get_group_by_name($name)
{
    global $dbh;
    $stmt = $dbh->prepare("select * from groups where group_name = :name");
    $stmt->bindParam(':name', $name);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_group_by_id($group_id)
{
    global $dbh;
    $stmt = $dbh->prepare("select * from groups where group_id = :group_id");
    $stmt->bindParam(':group_id', $group_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_user_groups($user_id)
{
    global $dbh;
    $stmt = $dbh->prepare("select * from groups_joined j inner join groups g on j.group_id = g.group_id where j.user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function get_num_users_per_group($group_id)
{
    global $dbh;
    $stmt = $dbh->prepare("select * from groups_joined where group_id = $group_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return count($result);
}

function is_member_of_group($user_id, $group_id)
{
    global $dbh;
    $stmt = $dbh->prepare("select * from groups_joined where user_id = :user_id and group_id = :group_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':group_id', $group_id);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return (count($result) >= 1);
}

function leave_group($group_id, $user_id)
{
    global $dbh;
    $stmt = $dbh->prepare("Delete from groups_joined where user_id = :user_id and group_id = :group_id");
    $stmt->bindParam(':group_id', $group_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
}

function get_group_leader($group_id)
{
    global $dbh;
    $stmt = $dbh->prepare("select * from groups where group_id = :group_id");
    $stmt->bindParam(':group_id', $group_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function change_group_leader($group_id, $new_user_id)
{
    global $dbh;
    $stmt = $dbh->prepare("update groups set user_id = :new_user_id where group_id = :group_id");
    $stmt->bindParam(':group_id', $group_id);
    $stmt->bindParam(':new_user_id', $new_user_id);
    $stmt->execute();
}

function get_new_group_leader($group_id)
{
    global $dbh;
    $stmt = $dbh->prepare("select * from groups_joined where group_id = :group_id LIMIT 1");
    $stmt->bindParam(':group_id', $group_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function delete_group($group_id)
{
    global $dbh;
    $stmt = $dbh->prepare("Delete from groups where group_id = :group_id");
    $stmt->bindParam(':group_id', $group_id);
    $stmt->execute();
}

function get_group_members($group_id)
{
    global $dbh;
    $stmt = $dbh->prepare("select * from groups_joined gj inner join users u on u.user_id = gj.user_id where gj.group_id = :group_id");
    $stmt->bindParam(':group_id', $group_id);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;

}

function get_desc_from_id($pid)
{
    global $dbh;
    $stmt = $dbh->prepare("select problem_description from problems where :pid = problem_id");
    $stmt->bindParam(':pid', $pid);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_problem_type_from_id($pid)
{
    global $dbh;
    $stmt = $dbh->prepare("select category from problems where :pid = problem_id");
    $stmt->bindParam(':pid', $pid);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function delete_problem($pid){
    global $dbh;
    $stmt = $dbh->prepare("delete from problems where problem_id = :pid");
    $stmt->bindParam(':pid', $pid);
    $stmt->execute();

    global $dbh;
    $stmt = $dbh->prepare("delete from submissions where problem_id = :pid");
    $stmt->bindParam(':pid', $pid);
    $stmt->execute();

}

function get_problem_from_id($pid)
{
    global $dbh;
    $stmt = $dbh->prepare("select * from problems where problem_id = :pid");
    $stmt->bindParam('pid', $pid);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_creator_from_id($pid){
    global $dbh;
    $stmt = $dbh->prepare("select * from problems p inner join users u on p.user_id = u.user_id where p.problem_id = :pid");
    $stmt->bindParam(':pid', $pid);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_problems_by_solve_count()
{
    global $dbh;
    $stmt = $dbh->prepare("select * from (select *, count(problem_id) as solve_count from submissions s where s.submission_time >= DATE_ADD(CURDATE(), INTERVAL -7 DAY) group by problem_id) as s inner join problems p on p.problem_id = s.problem_id where p.group_id is null or p.group_id = 0 order by solve_count desc limit 3");
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function get_total_users()
{
    global $dbh;
    $stmt = $dbh->prepare("select * from users");
    $stmt->execute();
    $result = $stmt->fetchAll();
    return count($result);
}

function get_total_problems()
{
    global $dbh;
    $stmt = $dbh->prepare("select * from problems");
    $stmt->execute();
    $result = $stmt->fetchAll();
    return count($result);
}

function get_total_submissions()
{
    global $dbh;
    $stmt = $dbh->prepare("select * from submissions");
    $stmt->execute();
    $result = $stmt->fetchAll();
    return count($result);
}

function get_all_users()
{
    global $dbh;
    $stmt = $dbh->prepare("select username, user_id from users");
    $stmt->execute();
    $result = $stmt->fetchAll();
    return ($result);
}

function get_all_attempts_num($user_id){
    global $dbh;
    $stmt = $dbh->prepare("select * from submissions where user_id = :user_id amd correct = false");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return count($result);
}

function get_all_solves_num($user_id){
    global $dbh;
    $stmt = $dbh->prepare("select * from submissions where user_id = :user_id and correct = 1");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return count($result);
}


function add_comment($uid, $pid, $comment){
    global $dbh;
    $stmt = $dbh->prepare("INSERT INTO comments (uid, pid, comment) VALUES (:uid, :pid, :comment)");
    $stmt->bindParam('uid', $uid);
    $stmt->bindParam(':pid', $pid);
    $stmt->bindParam(':comment', $comment);
    $stmt->execute();
}


function get_comment_owner($cid){
    global $dbh;
    $stmt = $dbh->prepare("select * from comments c inner join users u on c.uid = u.user_id where c.cid = :cid");
    $stmt->bindParam(':cid', $cid);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['uid'];


}

function delete_comment($cid){
    global $dbh;
    $stmt = $dbh->prepare("delete from comments where cid = :cid");
    $stmt->bindParam(':cid', $cid);
    $stmt->execute();
}

function get_problem_id_by_comment($cid){
    global $dbh;
    $stmt = $dbh->prepare("select * from comments c inner join problems p on c.pid = p.problem_id where c.cid = :cid");
    $stmt->bindParam(':cid', $cid);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['pid'];
}

function get_comments($pid){
    global $dbh;
    $stmt = $dbh->prepare("select * from comments c inner join users u on c.uid = u.user_id where c.pid = :pid");
    $stmt->bindParam(':pid', $pid);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function get_recent_comments(){
    global $dbh;
    $stmt = $dbh->prepare("select * from comments c inner join users u on c.uid = u.user_id inner join problems p on p.problem_id = c.pid order by timestamp desc limit 7");
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function get_recent_users(){
    global $dbh;
    $stmt = $dbh->prepare("SELECT * FROM users order by account_created desc limit 15");
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function add_post($post, $uid, $iap){
    global $dbh;
    $stmt = $dbh->prepare("INSERT INTO posts (post, user_id, is_admin_post) VALUES (:post, :user_id, :is_admin_post)");
    $stmt->bindParam(':post', $post);
    $stmt->bindParam(':user_id', $uid);
    $stmt->bindParam(':is_admin_post', $iap);
    $stmt->execute();
}

function get_posts($limit){
    global $dbh;
    $stmt = $dbh->prepare("SELECT * FROM posts p inner join users u on p.user_id = u.user_id where p.is_admin_post != true order by timestamp desc limit :limit");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function get_admin_posts($limit){
    global $dbh;
    $stmt = $dbh->prepare("SELECT * FROM posts p inner join users u on p.user_id = u.user_id where p.is_admin_post order by timestamp desc limit :limit");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}


function get_post_by_id($post_id){
    global $dbh;
    $stmt = $dbh->prepare("select * from posts p inner join users u on u.user_id = p.user_id where post_id = :post_id");
    $stmt->bindParam(':post_id', $post_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}
