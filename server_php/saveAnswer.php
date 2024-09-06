<?php
session_start();
include "login_check.php";
include "database_conn.php";

if(!isset($_GET['QuizID']) OR !isset($_SESSION['questionList']) OR !isset($_SESSION['correctAnswerList'])){
    echo '<script>location.href="../index.html"</script>';
};

$QuizID = $_GET['QuizID'];

$questionList = $_SESSION['questionList'];
$correctAnswerList = $_SESSION['correctAnswerList'];

$totalScore = 0;
$sumUserScore = 0;

for($answerCount=0; $answerCount<count($correctAnswerList); $answerCount++){
    $rowCaseSensitive = $questionList[$answerCount][4];
    $question = 'question' . $answerCount+1;
        if($rowCaseSensitive == 1){
            if($_POST[$question] == $correctAnswerList[$answerCount][0]){
                $sumUserScore++;
            }
        }else{
            if(strtolower($_POST[$question]) == strtolower($correctAnswerList[$answerCount][0])){
                $sumUserScore++;
            }
        };
    $totalScore++;
    $sumTotalScore = $totalScore;
};

$sqlSave = "INSERT INTO USER_ANSWER (totalScore, UID, QuizID) VALUES ($sumUserScore, $UID, $QuizID);";
query($sqlSave);

unset($_SESSION['questionList']);
unset($_SESSION['correctAnswerList']);
unset($_SESSION['scoreList']);

echo "<script>location.href='../library(Results).php'</script>";