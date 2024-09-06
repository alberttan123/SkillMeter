<?php
include 'database_conn.php';

$username = $_POST['username'];
$email = $_POST['email'];

$pword = $_POST['pword'];
$pword = password_hash($pword, PASSWORD_BCRYPT);

$userType = $_POST['userType'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$phoneNum = $_POST['phoneNum'];

$checkSQL = "SELECT username FROM USER_INFO WHERE username='" . $username . "'";

if(mysqli_num_rows(query($checkSQL))>=1){
    echo "This username is already taken.";
}elseif(mysqli_num_rows(query($checkSQL))==0){
    $save = "INSERT INTO USER_INFO (username, email, pword, userType, firstName, lastName, phoneNum) VALUES ('$username', '$email', '$pword', $userType, '$firstName', '$lastName', '$phoneNum');";
    query($save);
    echo "valid";
}