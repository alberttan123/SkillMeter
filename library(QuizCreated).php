<?php
include "server_php/login_check.php";
include "server_php/database_conn.php";

$sqlMyQuiz = "SELECT title, subjectName, QuizID FROM QUIZ, SUBJECTS WHERE SUBJECTS.categoryID = QUIZ.categoryID AND author=" . $UID;
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
    <title>Your Quizzes</title>
    <link rel="stylesheet" href="css/library(QuizCreated).css">
    <link rel="stylesheet" href="css/Library(QuizCreated)1.css">

    <script>
        const QuizID = {};
        const QuizTitle = {};

        function deleteQuiz(num){
            var title = QuizTitle[num];
            var message = `Are you sure you want to delete ${title}?`;
            if(confirm(message) == true){
                var id = QuizID[num];
                var params = `QuizID=${id}`;
                let httpc = new XMLHttpRequest();
                var url = "server_php/deleteQuiz.php";
                httpc.open("post", url, true);
    
                httpc.onreadystatechange = function() {
                    if(httpc.readyState == 4 && httpc.status == 200){
                        window.alert(httpc.responseText);
                        location.reload();
                    }
                };
                httpc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                httpc.send(params);
            };
        }

    </script>
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
                <th><a href="library(Results).php">Results</a></th>
            </table>
        </div>
        <main>
            <?php
            if(mysqli_num_rows($resultMyQuiz) == 0){
                echo "<div class='section1'><h1>There is nothing to display.</h1></div>";
            }else{
            $QuizID = $quizList[0][2];
            $title = $quizList[0][0];
            $subject = $quizList[0][1];
            $titleSave = "'" . $title . "'";
            echo "<script>QuizID[0] = $QuizID</script>";
            echo "<script>QuizTitle[0] = $titleSave</script>";
            
            echo '
            <div class="section1">
                            <h2>Your Quizzes</h2>
                            <a href="userview_quiz.php?QuizID='. `'` . $QuizID . `'` .'"><img src="images/quiz_icon.png">
                            <table class="imgtable">
                                <tr>
                                    <th class="header">Title:</th>
                                    <th class="data">' . $title . '</th>
                                </tr>
                                <tr>
                                    <th class="header">Author:</th>
                                    <th class="data">Me</th>
                                </tr>
                                <tr>
                                    <th class="header">Category:</th>
                                    <th class="data">' . $subject . '</th>
                                </tr>
                            </table></a>
                            <button onclick="deleteQuiz(0)">Delete Quiz</button>
                        </div>
            ';
            for($generateCount=1; $generateCount < mysqli_num_rows($resultMyQuiz); $generateCount++){
                $QuizID = $quizList[$generateCount][2];
                $title = $quizList[$generateCount][0];
                $subject = $quizList[$generateCount][1];
                $titleSave = "'" . $title . "'";
                echo "<script>QuizID[$generateCount] = $QuizID</script>";
                echo "<script>QuizTitle[$generateCount] = $titleSave</script>";
                echo '
                    <div class="section2">
                                    <a href="userview_quiz.php?QuizID='. `'` . $QuizID . `'` .'"><img src="images/quiz_icon.png">
                                    <table class="imgtable">
                                        <tr>
                                            <th class="header">Title:</th>
                                            <th class="data">' . $title . '</th>
                                        </tr>
                                        <tr>
                                            <th class="header">Author:</th>
                                            <th class="data">Me</th>
                                        </tr>
                                        <tr>
                                            <th class="header">Category:</th>
                                            <th class="data">' . $subject . '</th>
                                        </tr>
                                        </table></a>
                                        <button onclick="deleteQuiz(' . $generateCount . ')">Delete Quiz</button>
                                </div>
                    ';
            };}
            ?>
        </main>
    </div>
</body>
</html>