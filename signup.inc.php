

// CONNECTION TO MAIL SERVER SCRIPT

<?php



    
        //Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

//required files
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
   


/*     */



    // REGISTRATION SCRIPT
    if (isset($_POST["submit"])) {

    
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];
    $pwdrepeat = $_POST["pwdrepeat"];
    
    require 'dbh.inc.php';
    require 'functions.inc.php';
    
    
    if(emptyInputSignup( $name, $email, $username, $pwd, $pwdrepeat) !== false) {           // if anything apart from false no matter what it is
        header("location: ../signup.php?error=emptyinput");
        exit();}
    
    if(invalidUid($username) !== false) {           // if anything apart from false no matter what it is
        header("location: ../signup.php?error=invalidUid");
        exit();}

    if(invalidPwd($pwd) !== false) {           // if password doesn't contain those characters
        header("location: ../signup.php?error=invalidPwd");
        exit();}
    
    

    if(invalidEmail($email) !== false) {           // we check if the email wasn't entered the right way
        header("location: ../signup.php?error=invalidEmail");
        exit();}

    if(pwdMatch($pwd, $pwdrepeat) !== false) {           // we check if the two passwords match
        header("location: ../signup.php?error=pwdsdontmatch");
        exit();}

    if(uidExists($conn, $username, $email) !== false) {           // we connect to DB and check if username exists
        header("location: ../signup.php?error=usernametaken");
        exit();}

    
    
    
    





//Create an instance; passing `true` enables exceptions


  $mail = new PHPMailer(true);

  $mail->SMTPOptions = array(
    'ssl' => array(
    'verify_peer' => false,
    'verify_peer_name' => false,
    'allow_self_signed' => true
    )
    );

    //Server settings
    $mail->isSMTP();                            //Send using SMTP
    $mail->SMTPDebug = 3;                          
    $mail->Host       = 'smtp.gmail.com';       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;             //Enable SMTP authentication
    $mail->Username   = 'paul.derrys@gmail.com';   //SMTP write your email
    $mail->Password   = 'vxxj pbzf dxqk xvjt';      //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           //Enable implicit SSL encryption
    $mail->Port       = 587;                                    

    //Recipients
    $mail->setFrom( 'paul.derrys@gmail.com', 'Onceadev'); // Sender Email and name
    $mail->addAddress($email );     //Add a recipient email  
    $mail->addReplyTo('paul.derrys@gmail.com', 'Onceadev'); // reply to sender email

             // if anything apart from false no matter what it is
        
      
    
    
    $mail->isHTML(true);               //Set email format to HTML
    $mail->Subject =  'Your credentials.';  // email subject headings
    
   /* $one = 'Hi ' . $_POST["name"]  . ', thanks for joining, you are now one of us!' . '<br>' . 'Here are your credentials: ' . '<br>' .
    'Username: ' . $_POST["uid"] . '<br>' . 'Password: ' . $_POST["pwd"] . '<br>' . 'Please remember to keep them in a safe place.'; */
    
    
    $one =  '<body style="background-color: #7b8ee0">' .  '<h3 style="font-family: "Raleway", sans-serif;"> Hey ' . $_POST["name"] . 
    '. Thanks for joining, you are now one of us!</h3>' . '<h4 style="font-family: "Raleway", sans-serif;">Here are your credentials: </h4>' .
    '<h4 style="font-family: "Raleway", sans-serif;"> Username: ' . $_POST["uid"] . '</h4>' . '<h4 style="font-family: "Raleway", sans-serif;">' . 'Password: ' .
    $_POST["pwd"] . '</h4>' . '<h4 style="font-family: "Raleway", sans-serif;">' . 'Please remember to keep them in a safe place.' . '</h4>' .'<br>'  . '</body>' ;
    $mail->Body    = $one;



    
            
    $mail->send();
        
    createUser($conn, $name, $email, $username, $pwd); 
    header("location: ../login.php");
    exit();
}

else{

    header("location: ../signup.php");
    exit();}

