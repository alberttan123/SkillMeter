<?php
session_start();
if(!isset($_GET['QuizID'])){
    echo "<script>location.href='index.html'</script>";
};
$QuizID = $_GET['QuizID'];

echo "<script>var QuizID=" . $QuizID . ";</script>";
include "server_php/login_check.php";
include "server_php/database_conn.php";
$sqlTitle = "SELECT title FROM QUIZ WHERE QuizID=" . $QuizID;
$title = fetch_row($sqlTitle)[0];

$sqlCategory = "SELECT subjectName FROM SUBJECTS, QUIZ WHERE SUBJECTS.categoryID = QUIZ.categoryID AND QuizID=" . $QuizID;
$category = fetch_row($sqlCategory)[0];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Quiz</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/userview_quiz.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        function generate(str, question_num){
            var boxID = `box${question_num}`;
            switch(str){
                case "":
                    document.getElementById(boxID).innerHTML = "";
                    break;
                case "0":
                    document.getElementById(boxID).innerHTML = `
                    <br>
                    <table>
                        <tr>
                            <td>Question: </td>
                            <td><input type="text" id="txtQuestion${question_num}" name="txtQuestion${question_num}" class="text_box" required></td>
                            <td>Case sensitive?</td>
                        </tr>
                        <tr>
                            <td>Answer: </td>
                            <td><input type="text" id="txtAnswer${question_num}" name="txtAnswer${question_num}" class="text_box" required></td>
                            <td rowspan=4 style="text-align: center;"><input type="checkbox" id="Question${question_num}CaseSensitive" name="Question${question_num}CaseSensitive"></td>
                        </tr>
                    </table>
                    `;
                    break;
                case "1":
                    document.getElementById(boxID).innerHTML = `
                    <br>
                    <table>
                        <form>
                        <tr>
                            <td>Question: </td>
                            <td><input type="text" id="txtQuestion${question_num}" name="txtQuestion${question_num}" class="text_box" required></td>
                            <td>Correct answer?</td>
                        </tr>
                        <tr>
                            <td style="vertical-align:top;">Answer: </td>
                            <td colspan=2>
                                <div><input type="text" id="Answer1Question${question_num}" name="Answer1Question${question_num}" class="text_box" required> <input type="radio" id="Question${question_num}Option1" name="Question${question_num}Option" value="Question${question_num}Option1"></div>
                                <div><input type="text" id="Answer2Question${question_num}" name="Answer2Question${question_num}" class="text_box" required> <input type="radio" id="Question${question_num}Option2" name="Question${question_num}Option" value="Question${question_num}Option2"></div>
                                <div><input type="text" id="Answer3Question${question_num}" name="Answer3Question${question_num}" class="text_box" required> <input type="radio" id="Question${question_num}Option3" name="Question${question_num}Option" value="Question${question_num}Option3"></div>
                                <div><input type="text" id="Answer4Question${question_num}" name="Answer4Question${question_num}" class="text_box" required> <input type="radio" id="Question${question_num}Option4" name="Question${question_num}Option" value="Question${question_num}Option4"></div>
                            </td>
                        </tr>
                        </form>
                    </table>
                    `;
                    break;}
        };

        var questionCount = 1;
        $(document).on("click", "#addQuestion", function(){
            $("#add_question").append(`
                <div class="top_section">
                    <h1 id="label${questionCount}">Question ${questionCount}</h1>
                    <select id="chooseType${questionCount}" name="chooseType${questionCount}" onchange="generate(this.value, ${questionCount})">
                        <option value="">Select question type:</option>
                        <option value="0">Short Answer</option>
                        <option value="1">Multiple Choice (single)</option>
                    </select>
                    <div id="box${questionCount}">
                    </div>
                    <br>
                    <button style="width: 20vw; height: 30px;" id="deleteQuestion${questionCount}" onclick="deleteQuestion(${questionCount})">Delete</button>
                </div>
            `);
            questionCount++;
        });

        function save(){
            let questionTypeList = [];
            let questionList = [];
            let answerList = [];
            let case_sensitiveList = [];
            
            var form = document.forms.questionForm;
            var formData = new FormData(form);
            
            var saveCount = 1;
            var emptyCount = 1;
            while(emptyCount < questionCount){
                var questionTypeCheck = formData.get(`chooseType${emptyCount}`);
                var correctAnswerSelected = formData.get(`Question${emptyCount}Option`);
                var question = formData.get(`txtQuestion${emptyCount}`);
                
                if(questionTypeCheck == "" || (questionTypeCheck == 1 && correctAnswerSelected == null) || question == ""){
                    document.getElementById(`box${emptyCount}`).scrollIntoView({behavior: 'smooth'});
                    window.alert(`Please check Question ${emptyCount}.`);
                    break;
                }else if(emptyCount == questionCount-1){
                    while(saveCount < questionCount){
                        var questionType = formData.get(`chooseType${saveCount}`);
                        var question = formData.get(`txtQuestion${saveCount}`);
                        var answer = formData.get(`txtAnswer${saveCount}`);
                        var case_sensitive = formData.get(`Question${saveCount}CaseSensitive`);
                        
                        if(case_sensitive == "on"){
                            case_sensitive = 1;
                        }else if(case_sensitive == "off"){
                            case_sensitive = 0;
                        }else{
                            case_sensitive = 0;
                        }
                        
                        switch(questionType){
                            case '0': 
                            questionTypeList.push(0);
                            questionList.push(question);
                            answerList.push(`${answer}|#|`);
                            case_sensitiveList.push(case_sensitive);
                            break;
                            
                            case '1': 
                            var correctAnswerSelected1 = formData.get(`Question${saveCount}Option`);
                            const possibleAnswers = [];
                            var possibleCount = 1;

                            while(possibleCount < 5){
                                var possible_answer = formData.get(`Answer${possibleCount}Question${saveCount}`);
                                var current = `Question${saveCount}Option${possibleCount}`

                                if(correctAnswerSelected1 == current){
                                    possibleAnswers.push('CORRECTANSWER' + `${possible_answer}`)
                                }else{
                                    possibleAnswers.push(possible_answer)
                                }
                                possibleCount ++;
                            }

                            questionTypeList.push(1);
                            questionList.push(question);
                            answerList.push(`${possibleAnswers}|#|`);
                            case_sensitiveList.push(case_sensitive);
                            break;
                        };
                        saveCount++
                    };
                    questionList = encodeURIComponent(questionList).replace("%20", "+");
                    answerList = encodeURIComponent(answerList).replace("%20", "+");
                    var params = `questionTypeList=${questionTypeList}&questionList=${questionList}&answerList=${answerList}&case_sensitiveList=${case_sensitiveList}&QuizID=${QuizID}`;
                    let httpc = new XMLHttpRequest();
                    var url = "server_php/saveQuiz.php";
                    httpc.open("post", url, true);
        
                    httpc.onreadystatechange = function() {
                        if(httpc.readyState == 4 && httpc.status == 200){
                            window.alert(httpc.responseText);
                            location.href= `library(QuizCreated).php`;
                        }
                    };
                    httpc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    httpc.send(params);
                };
                emptyCount++
            };
        };

        function replaceNum(startingNum){
            switch(startingNum){
                case questionCount-1:
                    questionCount = startingNum;
                    break;
                default:
                    for(let replaceCount = startingNum+1; replaceCount < questionCount; replaceCount++){
                        console.log('start');
                        var nextNum = replaceCount-1;
                        console.log(`change label${replaceCount} to ${nextNum}`);
                        document.getElementById(`label${replaceCount}`).innerHTML = `Question ${nextNum}`;
                        document.getElementById(`label${replaceCount}`).setAttribute("id", `label${nextNum}`);

                        document.getElementById(`deleteQuestion${replaceCount}`).setAttribute("onclick", `deleteQuestion(${nextNum})`);
                        document.getElementById(`deleteQuestion${replaceCount}`).setAttribute("id", `deleteQuestion${nextNum}`);

                        document.getElementById(`chooseType${replaceCount}`).setAttribute("onchange", `generate(this.value, ${nextNum})`); 
                        
                        document.getElementById(`box${replaceCount}`).setAttribute("id", `box${nextNum}`);
                        console.log('end')
                        console.log(`questionCount set to ${nextNum}`)
                        var questionCountReplace = nextNum+1;
                        
                        var form1 = document.forms.questionForm;
                        var formData1 = new FormData(form1);
                        var questionTypeCheck1 = formData1.get(`chooseType${replaceCount}`);
                        switch(questionTypeCheck1){
                            case '0':
                                console.log(`short answer`)
                                document.getElementById(`chooseType${replaceCount}`).setAttribute("name", `chooseType${nextNum}`); 
                                document.getElementById(`chooseType${replaceCount}`).setAttribute("id", `chooseType${nextNum}`); 
                                document.getElementById(`txtQuestion${replaceCount}`).setAttribute("name", `txtQuestion${nextNum}`)
                                document.getElementById(`txtQuestion${replaceCount}`).setAttribute("id", `txtQuestion${nextNum}`)
                                document.getElementById(`txtAnswer${replaceCount}`).setAttribute("name", `txtAnswer${nextNum}`)
                                document.getElementById(`txtAnswer${replaceCount}`).setAttribute("id", `txtAnswer${nextNum}`)
                                document.getElementById(`Question${replaceCount}CaseSensitive`).setAttribute("name", `Question${nextNum}CaseSensitive`)
                                document.getElementById(`Question${replaceCount}CaseSensitive`).setAttribute("id", `Question${nextNum}CaseSensitive`)
                                break;
                            case '1':
                                console.log('mcq');
                                document.getElementById(`chooseType${replaceCount}`).setAttribute("name", `chooseType${nextNum}`); 
                                document.getElementById(`chooseType${replaceCount}`).setAttribute("id", `chooseType${nextNum}`); 
                                document.getElementById(`txtQuestion${replaceCount}`).setAttribute("name", `txtQuestion${nextNum}`);
                                document.getElementById(`txtQuestion${replaceCount}`).setAttribute("id", `txtQuestion${nextNum}`);
                                document.getElementById(`Answer1Question${replaceCount}`).setAttribute("name", `Answer1Question${nextNum}`);
                                document.getElementById(`Answer1Question${replaceCount}`).setAttribute("id", `Answer1Question${nextNum}`);             
                                document.getElementById(`Answer2Question${replaceCount}`).setAttribute("name", `Answer2Question${nextNum}`);
                                document.getElementById(`Answer2Question${replaceCount}`).setAttribute("id", `Answer2Question${nextNum}`);                          
                                document.getElementById(`Answer3Question${replaceCount}`).setAttribute("name", `Answer3Question${nextNum}`);
                                document.getElementById(`Answer3Question${replaceCount}`).setAttribute("id", `Answer3Question${nextNum}`);                            
                                document.getElementById(`Answer4Question${replaceCount}`).setAttribute("name", `Answer4Question${nextNum}`);
                                document.getElementById(`Answer4Question${replaceCount}`).setAttribute("id", `Answer4Question${nextNum}`);                          
                                document.getElementById(`Question${replaceCount}Option1`).setAttribute("name", `Question${nextNum}`);
                                document.getElementById(`Question${replaceCount}Option1`).setAttribute("value", `Question${nextNum}Option1`);
                                document.getElementById(`Question${replaceCount}Option1`).setAttribute("id", `Question${nextNum}Option1`);                       
                                document.getElementById(`Question${replaceCount}Option2`).setAttribute("name", `Question${nextNum}`);
                                document.getElementById(`Question${replaceCount}Option2`).setAttribute("value", `Question${nextNum}Option2`);
                                document.getElementById(`Question${replaceCount}Option2`).setAttribute("id", `Question${nextNum}Option2`);                           
                                document.getElementById(`Question${replaceCount}Option3`).setAttribute("name", `Question${nextNum}`);
                                document.getElementById(`Question${replaceCount}Option3`).setAttribute("value", `Question${nextNum}Option3`);
                                document.getElementById(`Question${replaceCount}Option3`).setAttribute("id", `Question${nextNum}Option3`);                             
                                document.getElementById(`Question${replaceCount}Option4`).setAttribute("name", `Question${nextNum}`);
                                document.getElementById(`Question${replaceCount}Option4`).setAttribute("value", `Question${nextNum}Option4`);
                                document.getElementById(`Question${replaceCount}Option4`).setAttribute("id", `Question${nextNum}Option4`);
                                break;
                            default:
                                break;
                            }
                        questionCountReplace = replaceCount
                    }
                    questionCount = questionCountReplace;
                    break;
            }


        }

        function deleteQuestion(questionNum){
            replaceNum(questionNum)
            const element = document.getElementById(`deleteQuestion${questionNum}`);
            element.closest("div").remove()
        }

    </script>
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

            <form method="post" id="questionForm">
                <div id="add_question">  
                </div>
            </form>
            <div class="top_section">
                <button id="addQuestion">Add question</button>
            </div>

            <!-- bottom section -->
            <div class="bottom_section">
                <button onclick="save()" class="b_box_1">Save the quiz</button>
            </div>
        </form>
    </div>
</body>

</html>