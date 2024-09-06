<?php
session_start();
include 'login_check.php';
include 'database_conn.php';
$QuizID = $_POST['QuizID'];


$questionTypeList = $_POST['questionTypeList'];
$questionList = rawurldecode($_POST['questionList']);
$answerList = rawurldecode($_POST['answerList']);
$case_sensitiveList = $_POST['case_sensitiveList'];

$seperateQuestionType = explode(',', $questionTypeList);
$seperateQuestion = explode(',', $questionList);
$seperateAnswer = explode(',', $answerList);
$seperateCase_Sensitive = explode(',', $case_sensitiveList);

$seperateAnswer = explode('|#|,', $answerList);
$seperateAnswerEnd = explode('|#|', $seperateAnswer[count($seperateQuestionType)-1])[0];
$answerArray = array();

if(count($seperateQuestionType) != 1){
    for($count=0; $count < count($seperateQuestionType)-1; $count++){
        $answerArray[] = $seperateAnswer[$count];
        if($count == count($seperateQuestionType)-2){
            $answerArray[] = $seperateAnswerEnd;
        }
    };
}else if(count($seperateQuestionType) == 1){
    $answerArray[] = $seperateAnswerEnd;
};


$conn = mysqli_connect("localhost", "root", "", "asdf");

$countValid = 0;
for($count=0; $count < count($seperateQuestionType); $count++){
    $question = "'" . $seperateQuestion[$count] . "'";
    $answer = "'" . $answerArray[$count] . "'";
    $typeFlag = $seperateQuestionType[$count];
    $case_sensitive = $seperateCase_Sensitive[$count];
    $query = "INSERT INTO QUESTIONS (typeFlag, question, answer, casesensitiveFlag, score, QuizID) VALUES (" . $typeFlag . ", " . $question . ", " . $answer . ", " . $case_sensitive . ", 1, " . $QuizID . ");";
    query($query);
    $countValid++;
};
if($countValid == count($seperateQuestionType)){
    $queryTotalScore = "UPDATE QUIZ SET quizTotal = $countValid WHERE QuizID=$QuizID";
    query($queryTotalScore);
    echo "Successfully saved!";
}else{
    echo "Something went wrong.";
}
?>