<?php



$truepost;
function create_post($userzUid ,$data){
    
$userzUid =$_SESSION["userzUID"];
$emax =$_SESSION["userzE"];
//$pic =   "'" . "" . $emax ."/file.jpg'"   ;
$error = "";
$data = $_POST["post"];


//$pic =  "<a href='#' > <img  id='cont' src=" . "'" . "" . $emax ."/file.jpg'" . "width='120px' height='120px'></a>"  ;
if(!empty($data))
{
    $post = addslashes($data);
    
    $postid = postid();


    $server_name = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "mydb"; 

    $conn = mysqli_connect($server_name, $db_username, $db_password, $db_name);
    $sql = "INSERT INTO posts (userzUid, postid, post, image2, likedby) values ('$userzUid', '$postid', '$post' , '$emax', '0')";
    $result = mysqli_query($conn, $sql);

} 

else{$error = "Nothing was posted <br>";}

return $error;
}


function getPost($userzUid){
    $truepost=0;
    $server_name = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "mydb"; 

    $conn = mysqli_connect($server_name, $db_username, $db_password, $db_name);
    $sql = "SELECT * FROM posts WHERE userzUid = '$userzUid' order by ID desc ;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            
            $postxx[] = $row["post"];
            
            foreach ($postxx as $postx){
          
                $truepost = $postx;
                
                
        } 

        
    
        //echo $postx . "<br>" ;
        }

        }

       
   
    
    if($result){

        return $result;
    }


  
      
} 
    
        
        




function postid(){

$lenght = rand(4,19);
$number = "";
for($i=0; $i<$lenght ; $i++){

$new_rand = rand(0,9);
$number = $number . $new_rand;
}
return $number;
}




function like_post( $id, $type , $userzUid ){
$userzUid =$_SESSION["userzUID"];
$type = $_GET['type'];
if($type =="post"){
$server_name = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "mydb"; 

$conn = mysqli_connect($server_name, $db_username, $db_password, $db_name);





/***************** SO FAR SO GOOD ********************/


$sql = " SELECT * FROM likes ";   //selects from the table where the type is post and content id = postid
$result = mysqli_query($conn, $sql);

   //if(is_array($result) ){                        //checks in table if result is an array
    
    /*
    $likes = json_decode($result[0]['likes']);   //decodes the array
    
    $testid = json_decode($result['contentid']);
        
    $user_ids = array_column($likes, "userzUid"); */
   
   
   /* foreach ($result as $row){

        $user = $row['likes'];
        $posti = $row['contentid'];
    }
    */


    $sql = " SELECT * FROM posts "; 
    $result = mysqli_query($conn, $sql);

   

    $sql = " UPDATE posts set likes = likes +1  WHERE postid = '$id' limit 1 ";
    $result = mysqli_query($conn, $sql);
    //$arr['userzUid'] = $userzUid;  // get username from the person who liked
    //$arr["date"] = date("Y-m-d H:i:s");
    $arr = $userzUid;

    $arr2[] = $arr;
    $likes = json_encode($arr2); //convert array to string

    //$sql = "INSERT INTO likes (typex, contentid, likes) values('$type', '$id', '$userzUid') limit 1";
    $sql = " UPDATE posts set likedby = '$likes'  WHERE postid = '$id' limit 1 ";
    $result = mysqli_query($conn, $sql); 
/*
if(in_array($userzUid, $wholiked)){

    $sql = " UPDATE posts set likes = likes +0 WHERE postid = '$id' limit 1 ";
    $result = mysqli_query($conn, $sql);
   header("location: profile.php");

}*/





  /*  if($user === $userzUid && $posti === $id){
        $sql = " UPDATE posts set likes = likes +0 WHERE postid = '$id' limit 1 ";
        $result = mysqli_query($conn, $sql);
       header("location: profile.php");


    }  */

   

/*
    if(in_array($userzUid, $user_ids)){
    
        $arr['userzUid'] = $userzUid;                        // inserts userid in array
        $arr["date"] = date("Y-m-d H:i:s"); // insterts date in array
        $likes[] = $arr;
    
        $likes_string = json_encode(($likes));}*/
/*
    if(!in_array($userzUid, $user_ids)){
    
    $arr['userzUid'] = $userzUid;                        // inserts userid in array
    $arr["date"] = date("Y-m-d H:i:s"); // insterts date in array
    $likes[] = $arr;

    $likes_string = json_encode(($likes));
    $sql = "UPDATE likes SET likes = '$likes_string' WHERE typex = 'post'  and contentid = '$id' limit 1 "; 
    $result = mysqli_query($conn, $sql);  }} */
   
   

 

  
}

echo $arr2;}

