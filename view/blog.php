<?php
/**
 * Created by PhpStorm.
 * User: luklas
 * Date: 11/2/16
 * Time: 11:19 AM
 */

$user = 'blog';
$pass = 'blog';

$dbh = new PDO('mysql:host=localhost;dbname=blog', $user, $pass);

function get_posts()
{
    global $dbh;
    $stmt = $dbh->prepare("select data from blog");
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function add_post($post){
    global $dbh;
    $sql = "";
    try {
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO blog VALUES ('$post')";
        $dbh->exec($sql);

    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
}

function delete_all_posts(){
    global $dbh;
    $sql = "";
    try {
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "delete from blog where 1 = 1";
        $dbh->exec($sql);

    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
}
?>

<?php
if(!isset($_GET['action'])) {
    echo("<h1>This is my secure blog</h1>");
    echo('<ul class="collection">');
    foreach (get_posts() as $post) {
        echo('<li class="collection-item">' . $post['data'] . '</li>');
    }
    echo('</ul>');
    echo('<a href="blog.php?action=show_add">Add Post</a>');
} else if($_GET['action'] == "show_add") {
    echo('<form action="blog.php" method="get">');
    echo('<input type="text" name="data">');
    echo('<input type="hidden" name="action" value="add">');

    echo('<button type="submit">Add Post</button>');
    echo('</form>');
} else if($_GET['action'] == "delete_all_posts"){
    delete_all_posts();
} else {
    add_post($_GET['data']);
    echo("<script>window.parent.parent.location.href=\"blog.php\"</script>");
}


