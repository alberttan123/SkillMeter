<?php
include "server_php/login_check.php";
include "server_php/database_conn.php";

$sqlCategories = "SELECT subjectName, categoryID FROM SUBJECTS";
$categoriesResult = query($sqlCategories);

$sqlQuizID = "SELECT MAX(QuizID) FROM QUIZ";
$newQuizID = fetch_array($sqlQuizID)[0] + 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Quiz</title>
    <link rel="stylesheet" href="css/create_quiz.css">
    <link rel="stylesheet" href="css/style.css">
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
        <form action="#" method="post">
            <!-- top section -->
            <div class="top_section">
                <label for="Quiz Title">Quiz Title</label>
                <input type="text" name="quizTitle" placeholder="Quiz Title"><br>

                <label for="Category">Category</label>
                <select name="quizCategory" id="ddl_category">
                    <?php for($categoryCount = 0; $categoryCount < mysqli_num_rows($categoriesResult); $categoryCount++){
                    $row = mysqli_fetch_array($categoriesResult);
                    $categoriesRow = $row[0];
                    $categoriesIDRow = $row[1];
                    echo "<option value='$categoriesIDRow'>$categoriesRow</option>";}?>
                    </select><br>
                <input type="submit" name="btnCreate" value="Create">
            </div>
        </form>
    </div>
</body>
</html>
<?php
if(isset($_POST["btnCreate"]) AND $_POST["quizTitle"] != ""){
    $chosenTitle = $_POST["quizTitle"];
    $chosenCategory = $_POST["quizCategory"];
    $sqlCreate = "INSERT INTO QUIZ (QuizID, title, author, categoryID) VALUES ($newQuizID, '$chosenTitle', $UID, $chosenCategory);";
    query($sqlCreate);
    echo "<script>location.href = 'createQuestion.php?QuizID=$newQuizID'</script>";
}
?>