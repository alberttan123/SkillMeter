<?php
if($_GET['QuizID'] == NULL){
    echo "<script>location.href='../index.html'</script>";
}

include "login_check.php";
include "database_conn.php";

$QuizID = $_POST['QuizID'];

$query = "DELETE FROM USER_ANSWER WHERE QuizID=" . $QuizID;
query($query);

$query = "DELETE FROM QUESTIONS WHERE QuizID=" . $QuizID;
query($query);

$query = "DELETE FROM QUIZ WHERE QuizID=" . $QuizID;
query($query);

echo "Quiz successfully deleted.";