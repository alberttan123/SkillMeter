<?php
include "database_conn.php";

$QuizID = $_POST['QuizID'];
$sql = "SELECT COUNT(*) FROM QUIZ WHERE QuizID=" . $QuizID;

if(fetch_row($sql)[0] == 1){
    echo "valid";
}else{
    echo "This quiz does not exist.";
}