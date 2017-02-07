

<?php
/**
 * Created by PhpStorm.
 * User: luklas
 * Date: 8/2/16
 * Time: 12:11 PM
 */


?>

<html>
<head>
    <?php include 'head.php'?>
</head>
<body>
<?php
if(isset($_SESSION['user']['logged_in']))
    include 'navbarloggedin.php';
else
    include 'navbar.php';

?>
<?php
echo(get_add_challenge_alerts());
?>


<div class="container section">
    <div class="row">
        <div class="col l8 push-l2">
            <h3>Edit challenge!</h3>
            <div class="section"></div>
            <form action="index.php?action=edit_challenge" method="post">

                <br>

                <label>Submit To</label>
                <select name="group" required>

                    <option value="public">Public</option>


                </select>

                <br>

                <label for="problemname">Problem Name</label>
                <input type="text" id="problemname" name="name" value="<?php echo($problem_name); ?>" disabled required>
                <br>

                <label for="description">Description</label>
                <textarea id="description" name="description" class="materialize-textarea" required><?php echo($desc); ?></textarea>
                <br>
                <p class="range-field">
                    <label for="difficulty">Difficulty</label>
                    <input type="range" id="difficulty" name="difficulty" min="1" max="10" value="<?php echo($difficulty); ?>" required>
                </p>
                <br>

                <label>Category</label>
                <input name="category" value="<?php echo($category); ?>">

                <br>
                <label for="flag">Flag</label>
                <input type="text" id="flag" title="0 - 100 chars, no whitespace" name="flag" value="<?php echo($flag); ?>" required>
                <input type="hidden" name="pid" value="<?php echo($problem_id); ?>">
                <br>
                <button type="submit" class="waves-effect waves-light btn orange">Edit Challenge</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
