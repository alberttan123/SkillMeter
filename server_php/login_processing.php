<?php
if (!isset($_POST['username']) OR !isset($_POST['pword'])){
    echo "<script>location.href='login.html';</script>";
};
$username = $_POST['username'];
$pword = $_POST['pword'];

$conn = mysqli_connect("localhost", "root", "", "asdf");

$sql = 'SELECT username, pword FROM user_info WHERE username="' . $_POST['username'] . '";';
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) != 0){
    $row = mysqli_fetch_array($result);
    if(password_verify($pword, $row[1])){
        $sqlUID = "SELECT UID FROM USER_INFO WHERE username='" . $username . "';";
        $resultUID = mysqli_query($conn, $sqlUID);
        $UID = mysqli_fetch_array($resultUID);

        setcookie('username', $username, time() + 86400 * 30, "/");
        setcookie('UID', $UID['UID'], time() + 86400 * 30, "/");
        echo "valid";
    }else{
        echo 'Incorrect password';}
}else{
    echo 'The username does not exist';   
};
?>