<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore</title>
    <!-- <link rel="stylesheet" href="css/explore.css"> -->
    <link rel="stylesheet" href="css/Explore1.css">
    <script>
        function change(){
            var subjectName = document.getElementById('subject').value;
            if(subjectName != ""){
            var params = `subject=${subjectName}`;
            let httpc = new XMLHttpRequest();
            var url = 'server_php/return_explore.php';
            httpc.open("post", url, true);
            httpc.onreadystatechange = function() {
                        if(httpc.readyState == 4 && httpc.status == 200){
                            if(httpc.responseText == ""){
                                document.getElementById('searchResult').innerHTML = "";
                                document.getElementById('quizzes').innerHTML = "<h2>There is nothing to display.<h2>";
                            }else{
                                document.getElementById('searchResult').innerHTML = "";
                                document.getElementById('quizzes').innerHTML = httpc.responseText;
                            }
                        }
                    };
            httpc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            httpc.send(params);}
        }

        window.addEventListener("load", function () {
                var form = document.getElementById("form");
                
                form.addEventListener("submit", function (event){
                    event.preventDefault();
                    
                    var searchBar = encodeURIComponent(document.getElementById('txtSearchBar').value);
                    var params1 = `searchBar=${searchBar}`;
                    let httpc1 = new XMLHttpRequest();
                    var url1 = 'server_php/search_quiz.php'
                    httpc1.open("post", url1, true);
                    httpc1.onreadystatechange = function() {
                        if(httpc1.readyState == 4 && httpc1.status == 200){
                            if(httpc1.responseText == ""){
                                document.getElementById('quizzes').innerHTML = "";
                                document.getElementById('searchResult').innerHTML = "<h2>There is nothing to display.</h2>";
                            }else{
                                document.getElementById('quizzes').innerHTML = "";
                                document.getElementById('searchResult').innerHTML = httpc1.responseText;
                            }
                        }
                    }
                    httpc1.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
                    httpc1.send(params1);
                })
            })
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
        <main>
            <div id="section1">
                <form action="#0" class="searchbar" method="POST" id="form">
                    <input type="text" placeholder="Search" name="txtSearchbar" id="txtSearchBar">
                    <button type="submit"><img src="images/search-icon.jpg">
                </form>
            </div>
            <div id="section2">
                <h2>Category</h2>
                <div class="select-container">
                    <select class="select-box" id="subject" onchange="change()">
                        <option value="">Select a Category</option>
                        <option value="1">English</option>
                        <option value="2">Bahasa Melayu</option>
                        <option value="3">Modern Maths</option>
                        <option value="4">Add Maths</option>
                        <option value="5">Chemistry</option>
                        <option value="6">Biology</option>
                        <option value="7">Physics</option>
                        <option value="8">History</option>
                        <option value="9">Others</option>
                    </select>
                    <!-- <div class="icon-container">
                        <i class="fa-solid fa-caret-down"></i>
                    </div> -->
                </div>
            </div>
            <h2>Quiz</h2><br><br><br><br>
            <div class="container" id="searchResult">
            </div>
            <div class="container" id="quizzes">
            </div>
        </main> 
    </div>
</body>
</html>