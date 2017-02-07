<?php


if(isset($_POST['username']) and isset($_POST['password'])) {
    if ($_POST['username'] == "admin" and $_POST['password'] == "71urlkufpsdnlkadsf") {
        echo("<h1>flag{p0st_d4t4_4ll_d4y}</h1>");
    } else {
        echo("<h1>Seems like your credentials are wrong!</h1>");
    }
} else {
    echo("<h1>This site takes POST data that you have not submitted!</h1>");
    echo("<!-- username: admin | password: 71urlkufpsdnlkadsf -->");
}

