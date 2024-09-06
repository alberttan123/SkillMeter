<?php
include "server_php/login_check.php";
include "server_php/database_conn.php";

$sqlMyQuiz = "SELECT title, subjectName, QUIZ.QuizID, totalScore FROM QUIZ, SUBJECTS, USER_ANSWER WHERE USER_ANSWER.QuizID = QUIZ.QuizID AND SUBJECTS.categoryID = QUIZ.categoryID AND USER_ANSWER.UID=" . $UID;
$resultMyQuiz = query($sqlMyQuiz);

for($rowCount=mysqli_num_rows($resultMyQuiz); $rowCount > 0; $rowCount--){
    $quizList[] = mysqli_fetch_row($resultMyQuiz);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your results</title>
    <link rel="stylesheet" href="css/library(QuizCreated).css">
    <link rel="stylesheet" href="css/Library(Results)1.css">

</head>
<body>
    <div class="wrapper">
        <nav>
            <!-- phone sidebar -->
            <ul class="sidebar">
                <li onclick="hidesidebar()"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/></svg></a></li>
                <li><a href="index.html">SkillMeter <img src="images/logo1.png" alt="logo" class="logo"></a></li>
                <li><a href="library(QuizCreated).php">LIBRARY</a></li>
                <li><a href="create_quiz.php">CREATE</a></li>
                <li><a href="explore.php">EXPLORE</a></li>
                <li><a href="profile.php">PROFILE</a></li>
            </ul>
            <ul>
                <!-- header -->
                <li><a href="index.html"><img src="images/logo1.png" alt="logo" class="logo"> SkillMeter</a></li>
                <li class="mobilehideheader"><a href="library(QuizCreated).php">LIBRARY</a></li>
                <li class="mobilehideheader"><a href="create_quiz.php">CREATE</a></li>
                <li class="mobilehideheader"><a href="explore.php">EXPLORE</a></li>
                <li class="mobilehideheader"><a href="profile.php">PROFILE</a></li>
                <li onclick= "showsidebar()" class="menu_button"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg></a></li>
            </ul>
        </nav>
    
        <script>
            function showsidebar(){
                const sidebar = document.querySelector('.sidebar')
                sidebar.style.display = "flex"
            }
    
            function hidesidebar(){
                const sidebar = document.querySelector('.sidebar')
                sidebar.style.display = "none"
            }   
        </script>
    <div class="container">
        <div class="choicebar">
            <table class="choicebartable">
                <th><a href="library(QuizCreated).php">Your Quizzes</a></th>
            </table>
        </div>
        <main style="margin-left:300px;">
            <?php
            if(mysqli_num_rows($resultMyQuiz) == 0){
                echo "<div class='section1'><h1>There is nothing to display.</h1></div>";
            }else{
            $QuizID = $quizList[0][2];
            $title = $quizList[0][0];
            $subject = $quizList[0][1];
            $marks = $quizList[0][3];
            $countQuery = "SELECT COUNT(*) FROM QUESTIONS, QUIZ WHERE QUESTIONS.QuizID = QUIZ.QuizID AND QUIZ.QuizID=" . $QuizID;
            $quizTotal = fetch_row($countQuery)[0];
            
            echo '
            <div class="section1">
                            <h2>Results</h2>
                            <img src="images/quiz_icon.png">
                            <table class="imgtable">
                                <tr>
                                    <th class="header">Title:</th>
                                    <th class="data">' . $title . '</th>
                                </tr>
                                <tr>
                                    <th class="header">Category:</th>
                                    <th class="data">' . $subject . '</th>
                                </tr>
                                <tr>
                                    <th class="header">Marks:</th>
                                    <th class="data">' . $marks . '/' . $quizTotal . '</th>
                                </tr>
                            </table>
                        </div>
            ';
            for($generateCount=mysqli_num_rows($resultMyQuiz)-1; $generateCount > 1; $generateCount--){
                $QuizID = $quizList[$generateCount][2];
                $title = $quizList[$generateCount][0];
                $subject = $quizList[$generateCount][1];
                $marks = $quizList[$generateCount][3];
                $countQuery = "SELECT COUNT(*) FROM QUESTIONS, QUIZ WHERE QUESTIONS.QuizID = QUIZ.QuizID AND QUIZ.QuizID=" . $QuizID;
                $quizTotal = fetch_row($countQuery)[0];
                echo '
                    <div class="section2">
                                    <img src="images/quiz_icon.png">
                                    <table class="imgtable">
                                        <tr>
                                            <th class="header">Title:</th>
                                            <th class="data">' . $title . '</th>
                                        </tr>
                                        <tr>
                                            <th class="header">Category:</th>
                                            <th class="data">' . $subject . '</th>
                                        </tr>
                                        <tr>
                                            <th class="header">Marks:</th>
                                            <th class="data">' . $marks . '/' . $quizTotal . '</th>
                                        </tr>
                                        </table>
                                </div>
                    ';
            };}
            ?>
        </main>
    </div>
</body>
</html>