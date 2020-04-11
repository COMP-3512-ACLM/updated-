<?php
session_start();
include "includes/helpers.inc.php";
?>
<!DOCTYPE html>
<html lang=en>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style/reset.css" />
    <link rel="stylesheet" href="style/style.css" />
    <link rel="stylesheet" href="style/about.css" />
    <script src="script/header.js"></script>
</head>
<body >
    <?php outputHeader(); ?>
<main>
    <div id="about">
        <h1>About</h1>
        <h2>Description</h2>
        <p>This website was created for our Web II assignment 2. It's main purpose is to act as a movie database where users can search for potential films to watch using a variety of filters. We were assigned this project in our winter semester of 2020 by our COMP 3512 teacher, Randy Connolly. Through the use of technologies such as Heroku and JawsDB MySQL we were able to host our website for internet access
        <br>
        <br>
        <h2>Github</h2>
        <p>Our Team Members:</p>
        <ul>
            <li><a href="https://github.com/chunt661">Christian Hunter</a></li>
            <li><a href="https://github.com/HansP139">Hans Panghulan</a></li>
            <li><a href="https://github.com/AnalogVideo">Austin Voo</a></li>
            <li><a href="https://github.com/Mt1299">Matthew Lo</a></li>
            <li><a href="https://github.com/GoldHams">Luke Hermanson</a></li>
        </ul>
        <br>        
        <p>Project Repo: <a href="https://github.com/COMP-3512-ACLM/asg2">Web II Assignment 2</a></p>
        <br>
        <h2>External Resources:</h2>
        <p>Something here...</p>
    </div>
    
</main>    
</body>
</html>