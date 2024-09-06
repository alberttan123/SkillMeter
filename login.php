<?php
if (isset($_COOKIE['username']) OR isset($_COOKIE['UID'])){
    echo "<script>location.href='index.html';</script>";
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script>
            window.addEventListener("load", function () {
                var form = document.getElementById("form");
                
                form.addEventListener("submit", function (event) {
                    event.preventDefault();
                    
                    var username = encodeURIComponent(document.getElementById('username').value);
                    var pword = encodeURIComponent(document.getElementById('pword').value);
                    var params = `username=${username}&pword=${pword}`;
                    let httpc = new XMLHttpRequest();
                    var url = 'server_php/login_processing.php';
                    httpc.open("post", url, true);
                    httpc.onreadystatechange = function() {
                                if(httpc.readyState == 4 && httpc.status == 200){
                                    if(httpc.responseText != "valid"){
                                        window.alert(httpc.responseText);
                                    }else if(httpc.responseText == "valid"){
                                        location.href = "index.html";
                                    }
                                }
                            };
                    httpc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    httpc.send(params);
                });
            });
    </script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
            color: #fff;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: url("images/banner1.png")
        }
        .wrapper {
            width: 420px;
            background-color: transparent;
            border: 2px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(20px);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            color: white;
            border-radius: 10px;
            padding: 30px 50px;
        }
        .wrapper h1 {
            font-size: 36px;
            text-align: center;
        }
        .input-box {
            height: 50px;
            margin: 30px 0;
            width: 100%;
            max-width: 600px;
            background-color: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            border-radius: 50px;
            padding: 10px 20px;
            backdrop-filter: blur(5px) saturate(100%);
        }
        .input-box input{
            width: 100%;
            height: 100%;
            background: transparent;
            border: none;
            outline: none;
            border: 2px solid rbga(255, 255, 255, 0.2);
            border-radius: 40px;
            font-size: 16px;
            color: #fff;
            padding: 20px 45px 20px 20px;
        }
        .input-box input::placeholder {
            color: #fff;
        }
        .input-box i {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
        }
        .wrapper .btn {
            width: 315px;
            height: 45px;
            background-color: #fff;
            border: none;
            outline: none;
            border-radius: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0,0.1);
            cursor: pointer;
            font-size: 14px;
            color: #333;
            font-weight: 600;
        }
        .wrapper.register-link {
            font-size: 14.5px;
            margin: 20px 0 15px 20px;
            text-align: center;
        }
        .register-link p a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            text-align: center;
        }
        .register-link p a:hover {
            text-decoration: underline;
        }


    </style>
</head>
<body>
    <div class="wrapper">
        <form id="form" action="#0" method="post">
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" placeholder="Username" id="username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Password" id="pword" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <button type="submit" class="btn" name="btnLogin">Login</button>

            <div class="register-link">
                <br><p>Don't have an account?<a href="register.html"> Register now.</a></p>
            </div>
        </form>
    </div>
</body>
</html>