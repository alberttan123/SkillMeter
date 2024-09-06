<?php
function fetch_array($query){
    $conn = mysqli_connect("localhost", "root" ,"", "asdf");
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_array($result);
}

function fetch_row($query){
    $conn = mysqli_connect("localhost", "root" ,"", "asdf");
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_row($result);
}

function query($query){
    $conn = mysqli_connect("localhost", "root" ,"", "asdf");
    return mysqli_query($conn, $query);
}