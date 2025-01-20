<?php



function emptyInputSignup($name, $email, $username, $pwd, $pwdrepeat) {

    $results =0;
    if(empty($name) || empty($email) || empty($username) ||empty($pwd) ||empty($pwdrepeat)){$results = true;}
    else{ $results = false;}
    
    return $results;}

function emptyreset( $email, $otp) {

        $results =0;
        if(empty($email) ||empty($otp)){$results = true;}
        else{ $results = false;}
        
        return $results;}



function invalidUid($username) {

    $results =0;

    if(!preg_match("/^[a-zA-Z0-9]*$/" , $username)){
        $results = true;}
    else{$results = false;}
        
    return $results;}
function invalidPwd($pwd){
    
    $results =0;
    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/";

    if(!preg_match($pattern , $pwd)){
        $results = true;}
    else{$results = false;}
        
    return $results;}


function invalidEmail($email) {

    $results =0;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){$results = true;}
    else{ $results = false;}
           
    return $results;}

function pwdMatch($pwd, $pwdrepeat) {

    $results =0;
    if($pwd != $pwdrepeat){$results = true;}   
    else{ $results = false;}
              
    return $results;}

function uidExists($conn, $username, $email) {

    $sql = "SELECT * FROM userz WHERE userzUid =? OR userzEmail =?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../signup.php?error=usernametaken");
        exit();}

        mysqli_stmt_bind_param($stmt, "ss", $username, $email);
        mysqli_stmt_execute($stmt);

        $resultdata = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($resultdata)){
            return $row;
        }
        else{
            $results = false;
            return $results;
        }
        mysqli_stmt_close($stmt);

        





    }

function createUser($conn, $name, $email, $username, $pwd) {

    $sql = "INSERT INTO userz (userzName, userzEmail, userzUid, userzPwd) VALUES(?,?,?,?); ";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../signup.php?error=somethingWentWrong");
        exit();}
    
   
        $hashedpwd = password_hash($pwd, PASSWORD_DEFAULT);
    
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedpwd);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ../signup.php?error=none");
        

        exit();

    
        $resultdata = mysqli_stmt_get_result($stmt);
    
        if($row = mysqli_fetch_assoc($resultdata)){
                return $row;
            }
        else{
            $results = false;
            return $results;
            }
        mysqli_stmt_close($stmt);}

function deleteUser($conn, $email, $pwd ) {
    
   

    $sql = "DELETE FROM userz WHERE userzEmail =? OR userzPwd =?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "YOU STINK";
        exit();}

        mysqli_stmt_bind_param($stmt, "ss", $email, $pwd);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);}
      


        
function emptyInputLogin($username, $pwd) {

            $results =0;
            if(empty($username) ||empty($pwd)){$results = true;}
            else{ $results = false;}
            
            return $results;}

function loginUser($conn, $username, $pwd){

    $uidExists = uidExists($conn, $username, $username);

    if($uidExists === false){header("location: ../login.php?error=wronglogin");
    exit();}

    $pwdHashed = $uidExists["userzPwd"];
    $checkPwd = password_verify($pwd , $pwdHashed);

    if($checkPwd === false){
        
            header("location: ../login.php?error=wronglogin");
            exit(); }

    else if($checkPwd ===true){
        session_start();
        $_SESSION["userzID"] = $uidExists["ID"];
        $_SESSION["userzUID"] = $uidExists["userzUid"];
        $_SESSION["userzE"] = $uidExists["userzEmail"];
            
        header("location: ../mainpage.php");
        exit();

    
}}

function random_pass($lower, $upper,$number,$symbol){

    $lower_case ="abcdefghijklmnopqrstuvwxyz";
    $uppercaseChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $numberChars = "0123456789" ;
    $symbolChars = "!@.,";

    $lower_case =str_shuffle($lower_case);
    $uppercaseChars =str_shuffle($uppercaseChars);
    $numberChars =str_shuffle($numberChars);
    $symbolChars =str_shuffle($symbolChars);

    

    $random_pass = substr($lower_case, 0 ,4);    // fromn lower_case from 0 to the lenght of random_caracters which is two
    $random_pass .= substr($uppercaseChars, 0 ,4);
    $random_pass .= substr($numberChars, 0 ,4);
    $random_pass .= substr($symbolChars, 0 ,4);

    return str_shuffle($random_pass);
    
   

  }
    

function otp($conn,  $otp, $email) {
/*
    $mailx = uidExists($conn, $email, $email);

    $mailxx = $mailx["userzEmail"];*/

    $sql = "UPDATE userz SET userzOTP = ? WHERE  userzEmail = ?; ";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../signup.php?error=somethingWentWrong");
        exit();}
    
   
        
      

       
    
        mysqli_stmt_bind_param($stmt, "ss",  $email,  $otp);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        

        exit();

    
        $resultdata = mysqli_stmt_get_result($stmt);
    
        if($row = mysqli_fetch_assoc($resultdata)){
                return $row;
            }
        else{
            $results = false;
            return $results;
            }
        mysqli_stmt_close($stmt);

        }

function resex($conn, $otp){

    $sql = "SELECT * FROM userz WHERE userzOTP = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../signup.php?error=usernametaken");
        exit();}

        mysqli_stmt_bind_param($stmt, "s", $otp);
        mysqli_stmt_execute($stmt);

        $resultdata = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($resultdata)){
            return $row;
        }
        else{
            $results = false;
            return $results;
        }
        mysqli_stmt_close($stmt);}


function logotp($conn, $otp){

        $otpExists = resex($conn, $otp);
        
        if($otpExists === false){header("location: ../resetpwd1.php?error=noexist");
        exit();}
        
        $otpx = $otpExists["userzOTP"];
        
        
        if($otpx !== $otp){
                
                    header("location: ../resetpwd1.php?error=nomatch");
                    exit(); }
        
        else if($otpx === $otp){
            session_start();
            $_SESSION["OTPX"] = $otpExists["userzOTP"];
                
                    
            header("location: ../resetpwd2.php");
            exit();
        
            
        }}

function newpwd($conn, $pwd, $email){
    
    $sql = "UPDATE userz SET userzPwd = ? WHERE  userzEmail = ?; ";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../signup.php?error=somethingWentWrong");
        exit();}
    
   
        $hashedpwd = password_hash($pwd, PASSWORD_DEFAULT);
    
        mysqli_stmt_bind_param($stmt, "ss",  $hashedpwd,  $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        header("location: ../mainpage.php?error=done!");
        session_start();
        unset($_SESSION["OTPX"]);
        
       
        
        exit();
    

        

    
        $resultdata = mysqli_stmt_get_result($stmt);
    
        if($row = mysqli_fetch_assoc($resultdata)){
                return $row;
                
            }
        else{
            $results = false;
            return $results;
            }
        //mysqli_stmt_close($stmt);


       
        }


function getAll($conn, $username, $email){

    $sql = "SELECT userzEmail, ID, userzName FROM userz ;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../signup.php?error=usernametaken");
        exit();}

        mysqli_stmt_bind_param($stmt, "ss", $username, $email);
        mysqli_stmt_execute($stmt);

        $resultdata = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($resultdata)){
            return $row;
        }
        else{
            $results = false;
            return $results;
        }
        mysqli_stmt_close($stmt);
}
?>


