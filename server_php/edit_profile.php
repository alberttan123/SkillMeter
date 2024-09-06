<?php
include "database_conn.php";

if(isset($_POST['firstName'])){
    $firstName = $_POST['firstName'];
    $sql = "UPDATE USER_INFO SET firstName ='" . $firstName . "' WHERE UID=" . $_COOKIE['UID'];
    query($sql);
    echo "valid";
}elseif(isset($_POST['lastName'])){
    $lastName = $_POST['lastName'];
    $sql = "UPDATE USER_INFO SET lastName ='" . $lastName . "' WHERE UID=" . $_COOKIE['UID'];
    query($sql);
    echo "valid";
}elseif(isset($_POST['email'])){
    $email = $_POST['email'];
    $sql = "UPDATE USER_INFO SET email ='" . $email . "' WHERE UID=" . $_COOKIE['UID'];
    query($sql);
    echo "valid";
}elseif(isset($_POST['pword'])){
    $pword = $_POST['pword'];
    $pword = password_hash($pword, PASSWORD_BCRYPT);
    $sql = "UPDATE USER_INFO SET pword ='" . $pword . "' WHERE UID=" . $_COOKIE['UID'];
    query($sql);
    echo "valid";
}