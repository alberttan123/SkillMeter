<?php
if (!isset($_COOKIE['username']) OR !isset($_COOKIE['UID'])){
    echo "<script>location.href='login.php';</script>";
};
$UID = $_COOKIE['UID'];
$username = $_COOKIE['username'];