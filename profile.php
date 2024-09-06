<?php
include "server_php/login_check.php";
include "server_php/database_conn.php";

$UID = $_COOKIE['UID'];
$sql = "SELECT firstName, lastName, email, pword, userType, username FROM USER_INFO WHERE UID = " . $UID;
$info = fetch_row($sql);

$firstName = $info[0];
$lastName = $info[1];
$email = $info[2];

$userType = $info[4];
switch($userType){
    case "0":
        $userType = "User";
        break;
    case "1":
        $userType = "Teacher";
        break;
    case "2":
        $userType = "Admin";
        break;
};

$username = $info[5];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/Profile1.css">

    <script>
        function sendRequest(type, data){
            var data = encodeURIComponent(data);
            switch(type){
                case 1:
                    var params = `firstName=${data}`;
                    break;
                case 2:
                    var params = `lastName=${data}`;
                    break;
                case 3:
                    var params = `email=${data}`;
                    break;
                case 4:
                    var params = `pword=${data}`;
                    break;
            }
            let httpc = new XMLHttpRequest();
            var url = 'server_php/edit_profile.php';
            httpc.open("post", url, true);
            httpc.onreadystatechange = function() {
                        if(httpc.readyState == 4 && httpc.status == 200){
                            if(httpc.responseText != "valid"){
                                window.alert("Something weng wrong");
                            }else if(httpc.responseText == "valid"){
                                window.alert("Successfully changed");
                                location.reload();
                            }
                        }
                    };
            httpc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            httpc.send(params);
        }

        function edit_info(type) {
            switch(type){
                //fname
                case 1:
                    form_firstName = document.getElementById('firstName').value;
                    if(form_firstName == ""){window.alert("Please enter a new value first.");break;}
                    var message = "Are you sure you want to change your first name to " + form_firstName + "?"
                    if(window.confirm(message) == true){
                        sendRequest(1, form_firstName);
                    }
                    break;
                
                //lname
                case 2:
                    form_lastName = document.getElementById('lastName').value;
                    if(form_lastName == ""){window.alert("Please enter a new value first.");break;}
                    var message = "Are you sure you want to change your last name to " + form_lastName + "?"
                    if(window.confirm(message) == true){
                        sendRequest(2, form_lastName);
                    }
                    break;

                //email
                case 3:
                    form_email = document.getElementById('email').value;
                    if(form_email == ""){window.alert("Please enter a new value first.");break;}
                    var message = "Are you sure you want to change your email to " + form_email + "?"
                    if(window.confirm(message) == true){
                        sendRequest(3, form_email);
                    }
                    break;

                //password
                case 4:
                    form_pword = document.getElementById('pword').value;
                    if(form_pword == ""){window.alert("Please enter a new value first.");break;}
                    var message = "Are you sure you want to change your password to " + form_pword + "?"
                    if(window.confirm(message) == true){
                        sendRequest(4, form_pword);
                    }
                    break;
            }
        }
    </script>
    <style>
        table td input {
            width: 100%;
            box-sizing: border-box;
            height: 40px;
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.8);
        }
        ::placeholder {
            font-size: 20px;

        }
    </style>
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
        <div id="pfpbox"><img src="images/pfp.png" class="profilepic"></div>
        <table>
            <tr>
                <td class="header">Username:</td>
                <td class="data"><?php echo $username?></td>
                <td class="img"><img src="images/red-x-png-4.png" class="NoEditlogo"></td>
            </tr>
            <tr>
                <td class="header">User Type:</td>
                <td class="data"><?php echo $userType?></td>
                <td class="img"><img src="images/red-x-png-4.png" class="NoEditlogo"></td>
            </tr>
            <tr>
                <td class="header">First Name:</td>
                <td class="data"><?php echo '<input type="text" placeholder="' . $firstName . '" id="firstName">'?></td>
                <td class="img"><img src="images/pencil-edit.png" class="editlogo" onclick="edit_info(1)"></td>
            </tr>
            <tr>
                <td class="header">Last Name:</td>
                <td class="data"><?php echo '<input type="text" placeholder="' . $lastName . '" id="lastName">'?></td>
                <td class="img"><a href="#"><img src="images/pencil-edit.png" class="editlogo" onclick="edit_info(2)"></a></td>
            </tr>
            <tr>
                <td class="header">Email:</td>
                <td class="data"><?php echo '<input type="email" placeholder="' . $email . '" id="email">'?></td>
                <td class="img"><a href="#"><img src="images/pencil-edit.png" class="editlogo" onclick="edit_info(3)"></a></td>
            </tr>
            <tr>
                <td class="header">Password:</td>
                <td class="data"><?php echo '<input type="text" placeholder="" id="pword">'?></td>
                <td class="img"><a href="#"><img src="images/pencil-edit.png" class="editlogo" onclick="edit_info(4)"></a></td>
            </tr>
        </table>
        <br><br><br>
        <div class="logout"><a href="server_php/logout.php">Logout</a></div>
    </div>
    <div id="edit_info"><div>
</body>
</html>
