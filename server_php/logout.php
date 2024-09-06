<?php
session_start();
setcookie('username', '', -1, "/");
setcookie('UID', '', -1, "/");
$_SESSION = [];

header("Location: ../index.html");