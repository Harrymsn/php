<?php 



include "config.php";
require "config.php";

function connect(){

    $mysqli = new mysqli(SERVER, USERNAME, PASSWORD, DATABASE);
    if($mysqli -> connect_errno !=0){

        $error = $mysqli ->connect_error;
        $error_date = date("F  j, Y, g:i a");
        $message = "{$error} | {$error_date} r\n" ;
        file_put_contents("db-log.txt" , $message, FILE_APPEND);
        return false;}
        
        else  {return $mysqli;} }

function registerUser( $username, $password, $confirm_password){
    $mysqli = connect();
    $args = func_get_args();

    $args =array_map(function($value){return trim($value);} , $args);

    foreach($args as $value) {
        if(empty($value)){return "All fields are required";}}

    foreach($args as $value){
        if(preg_match("/([<|>])/" , $value)){return "<> characters are not allowed";}}
    
    //if(!filter_var($email, FILTER_VALIDATE_EMAIL)){return "Email is not valid";}

    $stmt = $mysqli->prepare("SELECT username FROM users WHERE username =?");
    $stmt->bind_param("s" , $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    if($data != NULL){
        return "Email already exists";}

    if($password != $confirm_password){return "Passwords don't match!";}

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("INSERT INTO users( password, username) VALUES(?,?,))");
    $stmt->bind_param("sss", $hashed_password, $username);
    $stmt->execute();
    if($stmt->affected_rows !=1) { return "An error occurred please try again!";}
    else{ return "Success";}

}

function loginUser(){}

function logoutUser(){}

function passwordReset(){}

function deleteAccount(){}





