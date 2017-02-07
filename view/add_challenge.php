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
            <h3>Add a challenge!</h3>
            <div class="section"></div>
            <form action="index.php?action=add_challenge" method="post">

                <br>

                <label>Submit To</label>
                <select name="group" required>

                    <option value="public">Public</option>
                    <?php if(isset($groups)) { ?>
                        <?php foreach ($groups as $group) { ?>

                            <option
                                value="<?php echo($group['group_id']); ?>"><?php echo($group['group_name']); ?></option>

                        <?php }
                    }
                    ?>

                </select>

                <br>

                <label for="problemname">Problem Name</label>
                <input type="text" id="problemname" name="name" required>
                <br>

                <label for="description">Description</label>
                <textarea id="description" name="description" class="materialize-textarea" required></textarea>
                <br>
                <p class="range-field">
                    <label for="difficulty">Difficulty</label>
                    <input type="range" id="difficulty" name="difficulty" min="1" max="10" required>
                </p>
                <br>

                <label>Category</label>
                <select name="category" required>
                    <option value="Miscellaneous">Miscellaneous</option>
                    <option value="Cryptography">Cryptography</option>
                    <option value="Web Exploitation">Web Exploitation</option>
                    <option value="Forensics">Forensics</option>
                    <option value="Binary Exploitation">Binary Exploitation</option>
                    <option value="Programming">Programming</option>

                </select>
                <br>
                <label for="flag">Flag</label>
                <input type="text" id="flag" title="0 - 100 chars, no whitespace" name="flag" required>

                <br>
                <button type="submit" class="waves-effect waves-light btn orange">Add Challenge</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
