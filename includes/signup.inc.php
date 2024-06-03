<?php 

if(isset($_POST["submit"])) {
    
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $password_repeat = $_POST["passwordRepeat"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    

    if(emptyInputSignup($name , $email , $username , $password , $password_repeat) !== false) {
        header("location: ../signup.php?error=emptyinput");     
        exit();
    }

    if(invalidUid($username) !== false) {
        header("location: ../signup.php?error=invaliduid");     
        exit();

    }
    if(invalidEmail( $email ) !== false) {
        header("location: ../signup.php?error=invalidemail");     
        exit();
    }

    
    if(pwdMatch( $password , $password_repeat ) !== false) {
        header("location: ../signup.php?error=passwordsdontmatch");     
        exit();
    }
    
    if(uidExists( $conn , $username  , $email ) !== false) {
        header("location: ../signup.php?error=usernametaken");     
        exit();
    }

    createUser($conn , $username , $email , $password , $password_repeat);

}else {
    header("location: ../signup.php");
} 