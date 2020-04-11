<?php
//add the log in/ session thing and redirect to home page
require_once 'db-common.inc.php';
$errorMessage = "";
$loginError = "";
if (isset($_POST['loginButton'])){
    login();
}

if (isset($_POST['signupSubmit'])){
    registration();
}

//log in functions--------------------------------------------------------------
function login(){
    try{
        $connection = getConnection();
        if (isset($_POST['email']) && isset($_POST['password']) && $_POST['email'] != "" && $_POST['password'] != ""){
            
            $sql = 'select * from users where email=?';
            $emailEntered = $_POST['email'];
            $user = runQuery ($connection, $sql, array($emailEntered));
            $userRow = $user->fetch(PDO::FETCH_ASSOC);
            $connection = null;
            if (isset($userRow['email'])){ //make sure the email is there in the row
                if($userRow['email'] == $_POST['email']){//check to make sure the email matches the user's input
                    checkPassword($userRow, $_POST['password']);// use this function to check if password is correct
                }//end of inner if
            }//end of outer if
            else{//email not found then change the error message
                $GLOBALS['loginError'] = "The email entered is incorrect";
            }//end of else
        }//end of if
        else{// missing email or password
            $GLOBALS['loginError'] = "Missing the Email or Password field";
        }//end fo else
    }catch (PDOException $e){
        die( $e->getMessage() );
    }
}//end of function login()

//this function is to comapre the password in the DB to the password inputed
function checkPassword($row, $passwordEntered){
    $userPass = $row['password'];
    if (password_verify($passwordEntered, $userPass)){//this checks the password
        if(!isset($_SESSION['userLogin'])){//checks to see if a user is already loged in
            $_SESSION['userLogin'] = $row; //set the session to the row of user data from the database
            //header("Location: "); //this is commented out for now -- add the home page
        }//end of !isset
    }//end of password_verify
    else{//incorrect password
        $GLOBALS['loginError'] = "The password entered is incorrect";
    }//end of else
}//end of check password()
//end of log in functions--------------------------------------------------

//Sign up functions ---------------------------------------------------------------------------
//this function will set the form data to the session and call upon other functions to sign up
function registration(){
    //this will add the following form data the session, so if the user enters invalid info it will send them back with the data there
    $_SESSION['first'] = $_POST['fName'];
    $_SESSION['last'] = $_POST['lName'];
    $_SESSION['uCountry'] = $_POST['country'];
    $_SESSION['uEmail'] = $_POST['newEmail'];
    $_SESSION['uCity'] = $_POST['city'];
    $validEmail = false;
    $validPass = false;
    
    if(isset($_POST['newEmail'])){//checks to make email is there
        $validEmail = validateEmail($_POST['newEmail']);
    }
    if ($validEmail){//will only this if the email is valid 
        $validPass = validatePassword($_POST['newPass'], $_POST['confirmPass']);
    }
    
    if($validEmail && $validPass){//if the email is valid and the password and confirm password match
        createAccount($_POST['newEmail'], $_POST['newPass']);
    }//end of if
}//end of registration()

//this function will create the account with the info from the form
function createAccount($email, $password){
    try{
        $connection = getConnection(); 
        $hashedPass = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        $userId = getId();
        $sql = "insert into users (id, firstname, lastname, city, country, email, password, salt, password_sha256) values (?, ?, ?,  ?, ?, ?, ?, null, null)";
        $result = runQuery ($connection, $sql, array($userId, $_SESSION['first'], $_SESSION['last'], $_SESSION['uCity'], $_SESSION['uCountry'], $_SESSION['uEmail'], $hashedPass));
        session_unset(); //remove the values from the session
        
        //this will add the session and redirect them
        $userSql = "select * from users where email=$email";
        $row = runQuery($connection, $sql, null);
        if(!isset($_SESSION['userLogin'])){//checks to see if a user is already loged in
            $_SESSION['userLogin'] = $row->fetch(PDO::FETCH_ASSOC); //set the session to the row of user data from the database
            //header("Location: "); //this is commented out for now -- add the home page
        }//end of !isset
        $connection = null;
    }catch (PDOException $e){
        die( $e->getMessage() );
    }
}//end of createAccount()

//this function will get the id of the new user by counting the amount of current user + 1
function getId(){
    try{
        $connection = getConnection(); 
        $sql = "select count(id) as numOfAccounts from users";
        $result = runQuery ($connection, $sql, null);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $newId = $row['numOfAccounts'] + 1;
        return $newId;
    }catch (PDOException $e){
        die( $e->getMessage());
    }
}//end of getId()

//this function will validate email
function validateEmail($newEmail){
    try{
        $connection = getConnection();
        $sql = 'select email from users';
        $allUsers = runQuery ($connection, $sql, null);
        $connection = null;
        $valid = true;
        foreach ($allUsers as $user){//run through each row to see if the email matches up
            if($user['email'] == $newEmail){// if there is a match set the the valid flag to false
                $valid = false;
            }//end of if
        }//end of foreach
        if(!$valid){//displays the out 
            $GLOBALS['errorMessage'] = "The email provided is already in use, please try a different email.";
        }//end of if
        return $valid;
    }catch (PDOException $e){
        die( $e->getMessage());
    }
}//end of validateEmail()

//this function will make sure the 2 passwords match 
function validatePassword($password1, $password2){
    $result = null;
    if ($password1 == $password2){ //if the password and confirm password match
        $result = true;
    }//end of if
    else{
        $result = false;
        $GLOBALS['errorMessage'] = "The passwords do not match";
    }//end of else
    return $result;
}//end of validatePassword
//end of sign up functions ---------------------------------------------------------------------------

//log out function - this will remove the session
function logout(){
    session_destroy();
    header("Location: index.php");
}//end of log out

//this will display the user info in a list
function getUserInfo(){
    echo "<ul>";
        echo '<li>' . $_SESSION['userLogin']['firstname'] . '</li>';
        echo '<li>' . $_SESSION['userLogin']['lastname'] . '</li>';
        echo '<li>' . $_SESSION['userLogin']['city'] . '</li>';
        echo '<li>' . $_SESSION['userLogin']['country'] . '</li>';
    echo "</ul>";
}//end of getUserInfo


//the following 5 functions are for the form to dipslay the previous data
function displayFirst(){
    if(isset($_SESSION['first'])){
        echo $_SESSION['first'];
    }
    else{
        echo "";
    }
}
function displayLast(){
    if(isset($_SESSION['last'])){
        echo $_SESSION['last'];
    }
    else{
        echo "";
    }
}
function displayCity(){
    if(isset($_SESSION['uCity'])){
        echo $_SESSION['uCity'];
    }
    else{
        echo "";
    }
}
function displayCountry(){
    if(isset($_SESSION['uCountry'])){
        echo $_SESSION['uCountry'];
    }
    else{
        echo "";
    }
}
function displayEmail(){
    if(isset($_SESSION['uEmail'])){
        echo $_SESSION['uEmail'];
    }
    else{
        echo "";
    }
}
//end of the display form data
?>
