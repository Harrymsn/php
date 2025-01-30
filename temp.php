<?php
include 'headers/header6.php';

include 'post.php';

$userzUid = $_SESSION["userzUID"];


    
    if(isset($_SESSION["userzUID"])){
    echo "<h1 id= 'special'> This is your profile page  </h1> " ;}
    
     else{ session_start();
        session_unset();
        session_destroy();
        
        header("location: ../login.php?error=loggedout");
            exit();}
?>





        
        

 

<div class="grid-container7"   > 
<div class="grid-item11" >


<?php

if(isset($_GET['type']) && isset($_GET['id'])){

$server_name = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "mydb"; 

    $conn = mysqli_connect($server_name, $db_username, $db_password, $db_name);

    

    

    

    
    $sql = "SELECT * FROM posts WHERE postid = $_GET[id] ;";
    $result = mysqli_query($conn, $sql);


   
        foreach($result as $row){
            $row['date'] = date('d-m-y');
        

            include 'comment.php';




          
        }
       

       
      
        

}
        
            
            

//$counter ++;
//echo $counter;
      

        
    




?>



</div>

</div>


</section>