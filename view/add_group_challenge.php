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

                <label for="problemname">Problem Name </label>
                <input type="text" pattern=".{5,40}" title="5 - 40 characters" id="problemname" name="name" required>
                <br>

                <label for="description">Description</label>
                <textarea id="description" name="description" class="materialize-textarea" required></textarea>
                <br>
                <p class="range-field">
                    <label for="difficulty">Difficdulty</label>
                    <input type="range" id="difficulty" name="difficulty" min="1" max="10" required>
                </p>
                <br>

                <label>Materialize Select</label>
                <select name="category" required>
                    <option value="Miscellaneous">Miscellaneous</option>
                    <option value="Cryptography">Cryptography</option>
                    <option value="Web Exploitation">Web Exploitation</option>
                    <option value="Forensics">Forensics</option>
                    <option value="Binary Exploitation">Binary Exploitation</option>
                    <option value="Reconnaissance">Reconnaissance</option>

                </select>
                <br>
                <label for="flag">Flag</label>
                <input type="text" id="flag" pattern="^\w{10,40}$" title="10 - 40 characters, no whitespace" name="flag" required>

                <input type="hidden" name="group_id" value="<?php echo(htmlspecialchars($_GET['group_id'])); ?>">

                <br>
                <button type="submit" class="waves-effect waves-light btn orange">Add Challenge</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
