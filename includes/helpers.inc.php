<?php
require_once 'includes/db-users.inc.php';

define("LOGO", "Logo");

function outputHeader() {
    echo "<header>";
    
    echo '<img src="/asg2-combined/image/film.png">'; //change asg2-combined to new folder if updated
    echo "<button id='menu'><div></div><div></div><div></div></button>";
    
    echo "<nav>";
    
    outputNavLink("Home", "#");
    outputNavLink("Browse", "http://localhost/asg2-combined/browse-movies.php");
    if (isLoggedIn()) {
        outputNavLink("Favourites", "#");
    }
    outputNavLink("About", "http://localhost/asg2-combined/about.php");
    
    echo "<input type='text' placeholder='Search movies' />";
    
    if (isLoggedIn()) {
        echo "<span>";
        getName();
        echo "</span>";
        echo "<a href='logout.php' class='login'>Log Out</a>";
    } else {
        echo "<a href='http://localhost/asg2-combined/login.php' class='login'>Login</a>";
        echo "<a href='http://localhost/asg2-combined/signup.php' class='login important'>Sign Up</a>";
    }
    
    echo "</nav>";
    
    echo "</header>";
}

function outputNavLink($name, $href) {
    echo "<a href='$href'>$name</a>";
}

?>