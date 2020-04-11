<?php
session_start();
require_once 'includes/db-users.inc.php'; 
require_once 'includes/db-common.inc.php';
require_once 'includes/helpers.inc.php';

if (isLoggedIn()) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="style/reset.css" />
        <link rel="stylesheet" href="style/style.css" />
        <link rel="stylesheet" href="style/signup.css" />
        <script src="script/header.js"></script>
    </head>
    <body>
        <?php outputHeader(); ?>
        <main>
            <div id=signup>
            <h1>Sign Up</h1>
            <form method="post" action="" class="login"> 
                <p><?php echo $errorMessage; ?></p>
                <br>
                <span>First Name</span><input type="text" placeholder="First Name" name="fName" value="<?php displayFirst(); ?>" required> <br>
                <span>Last Name</span><input type="text" placeholder="Last Name" name="lName" value="<?php displayLast(); ?>" required><br>
                <span>City</span><input type="text" placeholder="City" name="city" value="<?php displayCity(); ?>"  required> <br>
                <span>Country</span><input type="text" placeholder="Country" name="country" value="<?php displayCountry(); ?>"  required> <br>
                <span>Email</span><input type="email" placeholder="email@example.com" name="newEmail" value="<?php displayEmail(); ?>"  required><?php ?><br>
                <span>Password</span><input type="password" minlength="8" name="newPass" required><br>
                <span>Confirm Password</span><input type="password" minlength="8" name="confirmPass" required><br>
                <input type="submit" name="signupSubmit" id="submit">
            </form>
            </div>
        </main>
    </body>
</html>