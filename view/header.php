<?php
/**
 * Created by PhpStorm.
 * User: luklas
 * Date: 11/1/16
 * Time: 10:27 PM
 */

if($_SERVER['HTTP_USER_AGENT'] != "Sup3rS3cr3tAg3nt"){
    echo("Sorry, it seems as if your user agent is not correct, in order to access this website. The one you supplied is: " . $_SERVER['HTTP_USER_AGENT']);
} else {
    if($_SERVER["HTTP_REFERER"] != "awesomesauce.com"){
        echo ("Sorry, it seems as if you did not just come from the site, \"awesomesauce.com\".");
    }
    else{
        echo ("Here is your flag: flag{did_this_m3ss_with_y0ur_h34d}");
    }
}





?>

<!-- Sup3rS3cr3tAg3nt  -->
