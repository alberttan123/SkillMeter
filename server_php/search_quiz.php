<?php
include "database_conn.php";

$searchBar = $_POST['searchBar'];
$sql = "SELECT title, subjectName, QuizID FROM QUIZ, SUBJECTS WHERE SUBJECTS.categoryID = QUIZ.categoryID AND QUIZ.title LIKE '" . $searchBar . "%';";
$resultMyQuiz = query($sql);

for($rowCount=0; $rowCount < mysqli_num_rows($resultMyQuiz); $rowCount++){
    $quizList[] = mysqli_fetch_row($resultMyQuiz);
}

for($generateCount=0; $generateCount < mysqli_num_rows($resultMyQuiz); $generateCount++){
    $QuizID = $quizList[$generateCount][2];
    echo '
    <a href="userview_quiz.php?QuizID='. $QuizID .'"><img src="images/quiz_icon.png">
    <div class="Quiz">
        <table>
            <tr>
                <th>Title:</th>
                <td>'
                . $quizList[$generateCount][0] .
                
                '</td>

            </tr>
            <tr>
                <th>Category:</th>
                <td>'
                . $quizList[$generateCount][1] .
                '
                </td>
            </tr>
        </table>
    </div>
    </a>
    ';
};

