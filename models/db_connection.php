<?php
/**
 * Created by PhpStorm.
 * User: luklas
 * Date: 7/31/16
 * Time: 10:15 PM
 */
$user = 'ctflearn';
$pass = 'ctflearn';

$dbh = new PDO('mysql:host=localhost;dbname=ctflearn', $user, $pass);

 $sql = "CREATE TABLE if not exists `bookmarks` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `friend_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  primary key(user_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $stmt = $dbh->prepare($sql);

    $stmt->execute();


 $sql = "CREATE TABLE if not exists `comments` (
  `comment` text NOT NULL,
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL,
  `uid` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `parent_comment_id` int(11) DEFAULT NULL,
  primary key (cid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$stmt = $dbh->prepare($sql);

    $stmt->execute();

   $sql = "CREATE TABLE if not exists `posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `post` varchar(300) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `is_admin_post` tinyint(1) NOT NULL,
  primary key (post_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";

$stmt = $dbh->prepare($sql);

    $stmt->execute();


    $sql = "CREATE TABLE if not exists `post_replies` (
  `post_id` int(11) NOT NULL,
  `reply_id` int(11) NOT NULL AUTO_INCREMENT,
  `reply` varchar(400) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `reply_parent` int(11) DEFAULT NULL,
  primary key (reply_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";

$stmt = $dbh->prepare($sql);

    $stmt->execute();
 
    $sql = "CREATE TABLE if not exists `problems` (
  `problem_name` varchar(40) NOT NULL,
  `problem_id` int(60) NOT NULL AUTO_INCREMENT,
  `problem_description` varchar(500) NOT NULL,
  `user_id` int(6) NOT NULL,
  `flag` varchar(40) NOT NULL,
  `difficulty` int(6) NOT NULL,
  `category` varchar(40) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  primary key (problem_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$stmt = $dbh->prepare($sql);

    $stmt->execute();


$sql = "CREATE TABLE if not exists `submissions` (
  `problem_id` int(6) DEFAULT NULL,
  `submission_id` int(6) NOT NULL AUTO_INCREMENT,
  `correct` tinyint(1) NOT NULL,
  `user_id` int(6) NOT NULL DEFAULT '67',
  `submission_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `group_id` int(11) NOT NULL,
  primary key (submission_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
";

$stmt = $dbh->prepare($sql);

    $stmt->execute();

    $sql = "CREATE TABLE if not exists `users` (
  `username` varchar(30) NOT NULL,
  `user_id` int(6) NOT NULL AUTO_INCREMENT,
  `email` varchar(60) NOT NULL,
  `account_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `hashed_password` varchar(200) NOT NULL,
  `hackscore` int(11) NOT NULL DEFAULT '1337',
  `is_admin` tinyint(1) DEFAULT '0',
  `profile_picture_path` varchar(60) NOT NULL DEFAULT 'Untitled-1.png',
  `receive_emails` tinyint(1) NOT NULL DEFAULT '1',
  primary key(user_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
";

$stmt = $dbh->prepare($sql);

    $stmt->execute();




?>