<?php
session_start();
if(!isset($_GET['QuizID'])){
    echo "<script>location.href='index.html'</script>";
};
$QuizID = $_GET['QuizID'];
include "server_php/login_check.php";
include "server_php/database_conn.php";
$sqlTitle = "SELECT title FROM QUIZ WHERE QuizID=" . $QuizID;
$title = fetch_row($sqlTitle)[0];

$sqlCategory = "SELECT subjectName FROM SUBJECTS, QUIZ WHERE SUBJECTS.categoryID = QUIZ.categoryID AND QuizID=" . $QuizID;
$category = fetch_row($sqlCategory)[0];

$sqlQuestion = "SELECT QuestionID, typeFlag, question, answer, casesensitiveFlag FROM QUESTIONS WHERE QuizID=" . $QuizID;
$questionResult = query($sqlQuestion);

$questionList = array();
for($row=0; $row<mysqli_num_rows($questionResult); $row++){
    $questionList[] = mysqli_fetch_row($questionResult);
};
$correctAnswerList = array();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Quiz</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/userview_quiz.css">
</head>

<body>
    <!-- header -->
    <nav>
        <ul class="sidebar">
            <li onclick="hidesidebar()"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/></svg></a></li>
            <li><a href="index.html">SkillMeter <img src="images/logo1.png" alt="logo" class="logo"></a></li>
            <li><a href="library(QuizCreated).php">LIBRARY</a></li>
            <li><a href="create_quiz.php">CREATE</a></li>
            <li><a href="explore.php">EXPLORE</a></li>
            <li><a href="profile.php">PROFILE</a></li>
        </ul>
        <ul>
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

    <div class="quiz_container">
            <!-- top section -->
            <div class="top_section">
                <label for="Quiz Tittle">Quiz Title</label>
                <div class="quiz_tittle"><?php echo $title?></div><br>

                <label for="Cathegory">Category</label>
                <div class="top_section"><?php echo $category?></div>
            </div>

            <?php
            echo '<form action="server_php/saveAnswer.php?QuizID='. $QuizID .'" method="post">';
            for($row=0; $row<mysqli_num_rows($questionResult); $row++){
                $rowType = $questionList[$row][1];
                $rowQuestion = $questionList[$row][2];
                $rowAnswer = $questionList[$row][3];

                echo "<form action='answerReview.php?QuizID=$QuizID' method='post'>";

                if($rowType == 0){
                    echo '
                        <div class="short_answer">
                        <label for="question" class="s_box_1">Question</label><br>
                        <div class="s_box_2">' . $rowQuestion . '</div><br>
                        
                        <label for="answer" class="s_box_3">Answer</label><br>
                        <input type="text" placeholder="Short Answer" class="s_box_4" name="question' . $row+1 .'">
                        </div>
                        ';
                        $correctAnswerList[] = array($rowAnswer);
                }elseif($rowType == 1){
                    echo '
                        <div class="mcq_container">
                        <label for="Question" class="box_1">Question</label><br>
                        <div class="box_2">' . $rowQuestion . '</div><br>
                        ';
                    $seperateAnswer = explode(",", $rowAnswer);
                    $possibleAnswer = array();
                    $correctAnswer = array();
                    for($count1=0; $count1<count($seperateAnswer); $count1++){
                        if(str_contains($seperateAnswer[$count1], "CORRECTANSWER")){
                            $correctAnswer[] = trim($seperateAnswer[$count1], "CORRECTANSWER");
                            $correctAnswerList[] = $correctAnswer;
                            $possibleAnswer[] = trim($seperateAnswer[$count1], "CORRECTANSWER");
                        }else{
                            $possibleAnswer[] = $seperateAnswer[$count1];
                        };
                    };

                    echo '
                    <label for="option 1" class="box_3">Option 1</label><br>
                    <input type="radio" name="question'. $row+1 .'" id="0question'. $row+1 .'" class="box_4" checked="checked" value="'.$possibleAnswer[0].'">
                    <label for="0question'. $row+1 .'" class="mcq_box_1">' . $possibleAnswer[0] . '</label>
                    ';
                    echo '
                    <label for="option 2" class="box_5">Option 2</label><br>
                    <input type="radio" name="question'. $row+1 .'" id="1question'. $row+1 .'" class="box_6" checked="checked" value="'.$possibleAnswer[1].'">
                    <label for="1question'. $row+1 .'" class="mcq_box_2">' . $possibleAnswer[1] . '</label>
                    ';
                    echo '
                    <label for="option 3" class="box_7">Option 3</label><br>
                    <input type="radio" name="question'. $row+1 .'" id="2question'. $row+1 .'" class="box_8" checked="checked" value="'.$possibleAnswer[2].'">
                    <label for="2question'. $row+1 .'" class="mcq_box_3">' . $possibleAnswer[2] . '</label>
                    ';
                    echo '
                    <label for="option 4" class="box_9">Option 4</label><br>
                    <input type="radio" name="question'. $row+1 .'" id="3question'. $row+1 .'" class="box_10" checked="checked" value="'.$possibleAnswer[3].'">
                    <label for="3question'. $row+1 .'" class="mcq_box_4">' . $possibleAnswer[3] . '</label>
                    </div>';
                };
            };
            $_SESSION['questionList'] = $questionList;
            $_SESSION['correctAnswerList'] = $correctAnswerList;
            ?>

            <!-- bottom section -->
            <div class="bottom_section">
                <input type="submit" name="btnAnswer" id="" class="b_box_1">
            </div>
        </form>
    </div>
</body>

</html>